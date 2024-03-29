<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\Generic\StringCollection;
use JTL\Nachricht\Message\Cache\MessageCache;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\Nachricht\Transport\SubscriptionSettings;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Log\EntityIdContext;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MessageConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'chn:message.consume';

    private AmqpConsumer $amqpConsumer;
    private MessageCache $messageCache;

    public function __construct(AmqpConsumer $amqpConsumer, MessageCache $messageCache, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->amqpConsumer = $amqpConsumer;
        $this->messageCache = $messageCache;
    }

    protected function configure()
    {
        $this->setDescription('Subscribe to all existing Event Queues and consume Messages from RabbitMQ')
            ->addOption(
                'entity',
                'e',
                InputOption::VALUE_OPTIONAL,
                'A EntityId to identify the current running process',
                '0'
            )
            ->addOption(
                'time-limit',
                't',
                InputOption::VALUE_OPTIONAL,
                'The time limit in seconds the worker can run',
                '-1'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $entityId = (string)$input->getOption('entity');
        $this->logger->replaceContext(new EntityIdContext($entityId));

        $io->writeln("Collect message queue(s) ...\n");
        $eventRoutingKeyList = new StringCollection();
        foreach ($this->messageCache->getMessageClassList() as $eventClass) {
            $routingKey = $this->messageCache->getRoutingKeyForMessage($eventClass);
            if (!empty($routingKey)) {
                $io->writeln(' - ' . $routingKey);
                $eventRoutingKeyList->add($routingKey);
            } else {
                $io->writeln(" - <error>RoutingKey is empty </> \"$eventClass\" skip");
            }
        }
        $timeLimit = (int)$input->getOption('time-limit');
        $subscriptionSettings = new SubscriptionSettings($eventRoutingKeyList, $timeLimit);

        $io->writeln("");
        $io->writeln("Consume Messages");
        $this->amqpConsumer->consume($subscriptionSettings);

        return 0;
    }
}
