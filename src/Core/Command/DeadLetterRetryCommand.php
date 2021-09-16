<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 7/23/21
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use DateTimeImmutable;
use Exception;
use JTL\Nachricht\Contract\Serializer\MessageSerializer;
use JTL\Nachricht\Contract\Transport\Amqp\AmqpQueueLister;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\Nachricht\Serializer\Exception\DeserializationFailedException;
use JTL\Nachricht\Transport\Amqp\AmqpHttpConnectionFailedException;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeadLetterRetryCommand extends AbstractCommand
{
    protected static $defaultName = 'queue:dead-letter.retry';

    private AmqpTransport $transport;
    private AmqpQueueLister $queueLister;
    private MessageSerializer $messageSerializer;

    public function __construct(
        AmqpTransport $transport,
        AmqpQueueLister $queueLister,
        MessageSerializer $messageSerializer,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->transport = $transport;
        $this->queueLister = $queueLister;
        $this->messageSerializer = $messageSerializer;
    }

    protected function configure(): void
    {
        $this->setDescription('Moves messages from the Dead Letter queue back to their original queues')
            ->addArgument('type', InputArgument::OPTIONAL, 'Which types of messages should be processed')
            ->addOption(
                'default-action',
                'd',
                InputOption::VALUE_REQUIRED,
                'Default action used outside of interactive mode',
                false
            )
            ->addOption(
                'older-than',
                'o',
                InputOption::VALUE_REQUIRED,
                'Created-Date has to be older than given Date'
            )
            ->addOption(
                'filter-by-lasterror',
                'f',
                InputOption::VALUE_REQUIRED,
                'Filter jobs by last error'
            )
            ->addOption(
                'reset-receives',
                'r',
                InputOption::VALUE_NONE,
                'Reset the number of receives'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws DeserializationFailedException
     * @throws AmqpHttpConnectionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $messageType = $input->getArgument('type');
        $defaultAction = $input->getOption('default-action');
        $olderThan = $input->getOption('older-than');
        $filterByLastError = $input->getOption('filter-by-lasterror');
        $resetReceives = $input->getOption('reset-receives');
        $interactive = $defaultAction === false;
        $defaultAction = (string)$defaultAction;

        if (!is_string($olderThan)) {
            $olderThan = null;
        }

        if (!is_string($filterByLastError)) {
            $filterByLastError = null;
        }

        if (!is_bool($resetReceives)) {
            $resetReceives = false;
        }

        $this->transport->connect();
        $queueList = $this->queueLister->listQueues(AmqpTransport::DEAD_LETTER_QUEUE_PREFIX);

        if ($messageType !== null) {
            $filteredQueueList = array_filter($queueList, static fn ($name) => stripos($name, $messageType) !== false);

            if (count($filteredQueueList) === 0) {
                $output->writeln("Could not find any queues matching the name '{$messageType}'");
                return Command::FAILURE;
            }

            if (count($filteredQueueList) > 1) {
                $selectedQueue = $this->io->choice(
                    'Multiple queues found. Please select one',
                    array_values($filteredQueueList)
                );
            } else {
                $selectedQueue = reset($filteredQueueList);
            }

            $this->processQueue(
                $selectedQueue,
                $interactive,
                $defaultAction,
                $resetReceives,
                $olderThan,
                $filterByLastError
            );
            return Command::SUCCESS;
        }

        if (count($queueList) === 0) {
            $output->writeln('No dead letter queues found');
            return Command::SUCCESS;
        }

        $this->printAndProcessQueues(
            $queueList,
            $interactive,
            $defaultAction,
            $resetReceives,
            $olderThan,
            $filterByLastError
        );
        return Command::SUCCESS;
    }

    /**
     * @param array $queueList
     * @param bool $interactive
     * @param string $defaultAction
     * @param bool $resetReceives
     * @param string|null $olderThan
     * @param string|null $filterByLastError
     * @throws DeserializationFailedException
     */
    private function printAndProcessQueues(
        array $queueList,
        bool $interactive,
        string $defaultAction,
        bool $resetReceives,
        ?string $olderThan,
        ?string $filterByLastError
    ): void {
        $printQueues = [];

        foreach ($queueList as $queue) {
            $messageCount = $this->transport->countMessagesInQueue($queue);
            $printQueues[$queue] = $messageCount;
        }

        arsort($printQueues, SORT_NUMERIC);
        $index = 0;

        foreach ($printQueues as $queue => $messageCount) {
            $this->io->writeln("{$index}: {$queue}: {$messageCount} messages");
            $index++;
        }

        $answer = $this->io->ask('Please select a queue to process');
        $queues = array_values($queueList);

        if (is_numeric($answer)) {
            $this->processQueue(
                $queues[(int)$answer],
                $interactive,
                $defaultAction,
                $resetReceives,
                $olderThan,
                $filterByLastError,
                $printQueues[$queues[(int)$answer]]
            );
        }
    }

    /**
     * @param string $queue
     * @param bool $interactive
     * @param string $defaultAction
     * @param bool $resetReceives
     * @param string|null $olderThan
     * @param string|null $filterByLastError
     * @param int|null $messageCount
     * @throws DeserializationFailedException
     */
    private function processQueue(
        string $queue,
        bool $interactive,
        string $defaultAction,
        bool $resetReceives,
        ?string $olderThan,
        ?string $filterByLastError,
        int $messageCount = null
    ): void {
        $numMessages = $messageCount;
        if ($numMessages === null) {
            $numMessages = $this->transport->countMessagesInQueue($queue);
        }

        $processedMessages = $skippedMessages = 0;
        $this->io->writeln("Found {$numMessages} messages in queue '{$queue}'");

        while ($processedMessages + $skippedMessages < $numMessages) {
            $message = $this->transport->getMessageFromQueue($queue, false);

            if ($message === null) {
                return;
            }

            /** @var AbstractEvent|AbstractAmqpTransportableMessage $event */
            $event = $this->messageSerializer->deserialize($message->getBody());

            if ($olderThan !== null) {
                $olderThanDate = new DateTimeImmutable($olderThan);

                if ($event instanceof AbstractEvent && $event->getCreatedAt() > $olderThanDate) {
                    $skippedMessages++;
                    continue;
                }
            }

            if ($filterByLastError !== null) {
                $lastErrorFilter = $filterByLastError;
                $lastErrorMessage = (string)$event->getLastErrorMessage();

                $distance = levenshtein($lastErrorFilter, $lastErrorMessage);

                if ($distance > strlen($lastErrorMessage) / 2
                    && stripos($lastErrorMessage, $lastErrorFilter) === false) {
                    $skippedMessages++;
                    continue;
                }
            }

            if ($interactive) {
                $this->interaction($message, $event, $resetReceives);
            } else {
                $this->actUponMessage($message, $defaultAction, $resetReceives);
            }

            $processedMessages++;
        }

        if ($skippedMessages > 0) {
            $this->io->writeln("Skipped {$skippedMessages} messages.");
        }
    }

    /**
     * @param AMQPMessage $message
     * @param mixed $event
     * @param bool $resetReceives
     * @throws DeserializationFailedException
     */
    private function interaction(AMQPMessage $message, $event, bool $resetReceives): void
    {
        $this->io->writeln(print_r($event, true));

        $action = (string)$this->io->choice(
            'Move job back to message queue?',
            ['yes', 'no', 'delete', 'skip'],
            'yes'
        );

        $this->actUponMessage($message, $action, $resetReceives);
    }

    /**
     * @param AMQPMessage $message
     * @param string $action
     * @param bool $resetReceives
     * @throws DeserializationFailedException
     */
    private function actUponMessage(AMQPMessage $message, string $action, bool $resetReceives): void
    {
        switch ($action) {
            case 'yes':
                $this->requeue($message, $resetReceives);
                return;
            case 'delete':
                $this->transport->ack($message);
                return;
        }
    }

    /**
     * @param AMQPMessage $message
     * @param bool $resetReceives
     * @throws DeserializationFailedException
     */
    private function requeue(AMQPMessage $message, bool $resetReceives): void
    {
        $newRoutingKey = substr($message->getRoutingKey(), 4);
        $message->setDeliveryInfo(
            $message->getDeliveryTag(),
            $message->isRedelivered(),
            $message->getExchange(),
            $newRoutingKey
        );

        if ($resetReceives === true) {
            /** @var AbstractEvent $event */
            $event = $this->messageSerializer->deserialize($message->getBody());
            $event->setReceiveCount(0);
            $message->setBody($this->messageSerializer->serialize($event));
        }

        $this->transport->ack($message);
        $this->transport->directPublish($message);
    }
}
