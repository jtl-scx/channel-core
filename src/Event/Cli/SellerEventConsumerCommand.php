<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\Nachricht\Collection\StringCollection;
use JTL\Nachricht\Event\Cache\EventCache;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\Nachricht\Transport\SubscriptionSettings;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
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
     * @var EventCache
     */
    private $eventCache;

    /**
     * SellerEventConsumerCommand constructor.
     * @param AmqpConsumer $amqpConsumer
     * @param EventCache $eventCache
     */
    public function __construct(AmqpConsumer $amqpConsumer, EventCache $eventCache)
    {
        parent::__construct();
        $this->amqpConsumer = $amqpConsumer;
        $this->eventCache = $eventCache;
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
        $eventRoutingKeyList = [];

        foreach ($this->eventCache->getEventClassList() as $eventClass) {
            $eventRoutingKeyList[] = $this->eventCache->getRoutingKeyForEvent($eventClass);
        }

        $subscriptionSettings = new SubscriptionSettings(StringCollection::from(...$eventRoutingKeyList));

        $this->amqpConsumer->consume($subscriptionSettings);
    }
}
