<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\SCX\Client\Channel\Model\SellerEventOfferEnd;
use JTL\SCX\Client\Channel\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmitEventCommand extends AbstractCommand
{
    protected static $defaultName = 'scx:event:emit';

    /**
     * @var AmqpEmitter
     */
    private $emitter;

    /**
     * @var AmqpConsumer
     */
    private $amqpConsumer;

    /**
     * EmitEventCommand constructor.
     * @param AmqpEmitter $emitter
     * @param AmqpConsumer $amqpConsumer
     */
    public function __construct(AmqpEmitter $emitter, AmqpConsumer $amqpConsumer)
    {
        parent::__construct();
        $this->emitter = $emitter;
        $this->amqpConsumer = $amqpConsumer;
    }

    protected function configure()
    {
        $this->setDescription('Manually emits an Event')
            ->addArgument('type');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->emitter->emit(
            new OfferEndEvent(
                uniqid('iamevent', true),
                new \DateTimeImmutable(),
                'System:Notification',
                new SellerEventOfferEnd([
                    'sellerId' => 'seller007',
                    'offerId' => '12345678',
                ])
            )
        );
    }
}
