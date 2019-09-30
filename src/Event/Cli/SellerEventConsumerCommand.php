<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\Nachricht\Collection\StringCollection;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\Nachricht\Transport\SubscriptionSettings;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Model\Queue;
use JTL\SCX\Lib\Channel\RabbitMq\MessageQueueDiscoverer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SellerEventConsumerCommand extends AbstractCommand
{
    protected static $defaultName = 'scx:event:consume:seller';

    /**
     * @var AmqpConsumer
     */
    private $amqpConsumer;

    /**
     * @var MessageQueueDiscoverer
     */
    private $queueDiscoverer;

    /**
     * SellerEventConsumerCommand constructor.
     * @param AmqpConsumer $amqpConsumer
     * @param MessageQueueDiscoverer $queueDiscoverer
     */
    public function __construct(AmqpConsumer $amqpConsumer, MessageQueueDiscoverer $queueDiscoverer)
    {
        parent::__construct();
        $this->amqpConsumer = $amqpConsumer;
        $this->queueDiscoverer = $queueDiscoverer;
    }

    protected function configure()
    {
        $this->setDescription('Consume seller events created from polling the SCX Channel API');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queueList = $this->queueDiscoverer->discover();

        $subscriptionSettings = new SubscriptionSettings(StringCollection::from(
            ...array_map(function (Queue $queue) {
                return $queue->getName();
            }, $queueList)
        ));

        $this->amqpConsumer->consume($subscriptionSettings);
    }
}
