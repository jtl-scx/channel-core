<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use DateTimeImmutable;
use Exception;
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\Nachricht\Transport\Amqp\AmqpConsumer;
use JTL\SCX\Client\Channel\Model\SellerEventOfferEnd;
use JTL\SCX\Client\Channel\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;
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
     * @return int|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->emitter->emit(
            new OfferEndEvent(
                uniqid('iamevent', true),
                new DateTimeImmutable(),
                new SellerEventOfferEnd([
                    'sellerId' => 'seller007',
                    'offerId' => '12345678',
                ])
            )
        );

        $this->emitter->emit(
            new OfferNewEvent(
                uniqid('test'),
                new DateTimeImmutable('now'),
                new SellerEventOfferNew(
                    [
                        'channelId' => 'foo',
                        'sellerId' => "111",
                        'quantity' => 5,
                        'priceList' => [
                            [
                                'id' => 'B2C',
                                'quantityPriceList' => [
                                    ['amount' => "80.12", "currency" => "EUR", "quantity" => 0]
                                ]
                            ],
                        ],
                        "title" => "Schöner Kratzbaum",
                        "sku" => "MySku_Kratzi1",
                        "ean" => "4011905437873"
                    ]
                )
            )
        );
    }
}
