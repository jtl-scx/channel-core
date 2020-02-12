<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\Generic\StringCollection;
use JTL\Nachricht\Event\Cache\EventCache;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\Nachricht\Transport\SubscriptionSettings;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-channel:event.consume';
    private AmqpConsumer $amqpConsumer;
    private EventCache $eventCache;

    public function __construct(AmqpConsumer $amqpConsumer, EventCache $eventCache, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->amqpConsumer = $amqpConsumer;
        $this->eventCache = $eventCache;
    }

    protected function configure()
    {
        $this->setDescription('Subscribe to all existing Event Queues and consume Messages from RabbitMQ');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln("Collect message queue(s) ...\n");
        $eventRoutingKeyList = new StringCollection();
        foreach ($this->eventCache->getEventClassList() as $eventClass) {
            $routingKey = $this->eventCache->getRoutingKeyForEvent($eventClass);
            if (!empty($routingKey)) {
                $io->writeln(' - ' . $routingKey);
                $eventRoutingKeyList->add($routingKey);
            } else {
                $io->writeln(" - <error>RoutingKey is empty </> \"$eventClass\" skip");
            }
        }
        $subscriptionSettings = new SubscriptionSettings($eventRoutingKeyList);

        $io->writeln("");
        $io->writeln("Consume Messages");
        $this->amqpConsumer->consume($subscriptionSettings);
    }
}
