<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use DateTimeImmutable;
use Exception;
use JTL\SCX\Client\Channel\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmitOfferNewEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OfferNewEvent';

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Helper command to emit OfferNewEvent for Testing')
            ->addArgument('ean', InputArgument::OPTIONAL, 'Offer EAN', null)
            ->addArgument('sku', InputArgument::OPTIONAL, 'Offer Sku', null)
            ->addArgument('title', InputArgument::OPTIONAL, 'Offer Title', null)
            ->addArgument('price', InputArgument::OPTIONAL, 'Offer Price', null)
            ->addArgument('quantity', InputArgument::OPTIONAL, 'Offer Quantity', 5)
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $this->prepareEvent($input, $output);
        $event = new OfferNewEvent(
            uniqid('test'),
            new DateTimeImmutable('now'),
            new SellerEventOfferNew($event)
        );
        $this->emit($event, $input, $output);
    }
}
