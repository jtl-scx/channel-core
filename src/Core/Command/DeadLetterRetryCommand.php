<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 7/23/21
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use DateTimeImmutable;
use JTL\Nachricht\Contract\Serializer\MessageSerializer;
use JTL\Nachricht\Contract\Transport\Amqp\AmqpQueueLister;
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
    protected static $defaultName = 'chn:dead-letter:retry';

    private AmqpTransport $transport;
    private AmqpQueueLister $queueLister;
    private MessageSerializer $messageSerializer;
    private $olderThan;
    private $filterByLastError;
    private $resetReceives;
    private string $defaultAction;

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
                null,
                InputOption::VALUE_REQUIRED,
                'Filter jobs by last error'
            )
            ->addOption(
                'reset-receives',
                null,
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
        $this->olderThan = $input->getOption('older-than');
        $this->filterByLastError = $input->getOption('filter-by-lasterror');
        $this->resetReceives = $input->getOption('reset-receives');
        $interactive = $defaultAction === false;
        $this->defaultAction = (string)$defaultAction;

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

            $this->processQueue($selectedQueue, $interactive);
            return Command::SUCCESS;
        }

        foreach ($queueList as $queue) {
            $this->processQueue($queue, $interactive);
        }

        return Command::SUCCESS;
    }

    /**
     * @param string $queue
     * @param bool $interactive
     * @throws DeserializationFailedException
     */
    private function processQueue(string $queue, bool $interactive): void
    {
        $messageCount = $this->transport->countMessagesInQueue($queue);
        $processedMessages = $skippedMessages = 0;
        $this->io->writeln("Found {$messageCount} messages in queue '{$queue}'");

        while ($processedMessages + $skippedMessages < $messageCount) {
            $message = $this->transport->getMessageFromQueue($queue, false);

            if ($message === null) {
                return;
            }

            /** @var AbstractEvent $event */
            $event = $this->messageSerializer->deserialize($message->getBody());

            if ($this->olderThan !== null) {
                $olderThan = new DateTimeImmutable((string)$this->olderThan);

                if ($event->getCreatedAt() > $olderThan) {
                    $skippedMessages++;
                    continue;
                }
            }

            if ($this->filterByLastError !== null) {
                $lastErrorFilter = (string)$this->filterByLastError;
                $lastErrorMessage = (string)$event->getLastErrorMessage();

                $distance = levenshtein($lastErrorFilter, $lastErrorMessage);

                if ($distance > strlen($lastErrorMessage) / 2
                    && stripos($lastErrorMessage, $lastErrorFilter) === false) {
                    $skippedMessages++;
                    continue;
                }
            }

            if ($interactive) {
                $this->interaction($message, $event);
            } else {
                $this->actUponMessage($message, $this->defaultAction);
            }

            $processedMessages++;
        }

        if ($skippedMessages > 0) {
            $this->io->writeln("Skipped {$skippedMessages} messages.");
        }
    }

    /**
     * @param AMQPMessage $message
     * @param AbstractEvent $event
     * @throws DeserializationFailedException
     */
    private function interaction(AMQPMessage $message, AbstractEvent $event): void
    {
        $this->io->writeln(print_r($event, true));

        $action = (string)$this->io->choice(
            'Move job back to message queue?',
            ['yes', 'no', 'delete', 'skip'],
            'yes'
        );

        $this->actUponMessage($message, $action);
    }

    /**
     * @throws DeserializationFailedException
     */
    private function actUponMessage(AMQPMessage $message, string $action): void
    {
        switch ($action) {
            case 'yes':
                $this->requeue($message);
                return;
            case 'delete':
                $this->transport->ack($message);
                return;
        }
    }

    /**
     * @param AMQPMessage $message
     * @throws DeserializationFailedException
     */
    private function requeue(AMQPMessage $message): void
    {
        $newRoutingKey = substr($message->getRoutingKey(), 4);
        $message->setDeliveryInfo(
            $message->getDeliveryTag(),
            $message->isRedelivered(),
            $message->getExchange(),
            $newRoutingKey
        );

        if ($this->resetReceives === true) {
            /** @var AbstractEvent $event */
            $event = $this->messageSerializer->deserialize($message->getBody());
            $event->setReceiveCount(0);
            $message->setBody($this->messageSerializer->serialize($event));
        }

        $this->transport->ack($message);
        $this->transport->directPublish($message);
    }
}
