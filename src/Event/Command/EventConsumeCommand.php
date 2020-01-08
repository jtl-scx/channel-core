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
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-channel:event.consume';

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
        $this->setDescription('Consume events from RabbitMQ');
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

        $eventRoutingKeyList = [];

        foreach ($this->eventCache->getEventClassList() as $eventClass) {
            $eventRoutingKeyList[] = $this->eventCache->getRoutingKeyForEvent($eventClass);
        }

        $io->writeln("start message consumer on RoutingKeys ...");
        $io->block(implode("\n", $eventRoutingKeyList));

        $subscriptionSettings = new SubscriptionSettings(StringCollection::from(...$eventRoutingKeyList));

        $this->amqpConsumer->consume($subscriptionSettings);
    }
}
