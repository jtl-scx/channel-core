<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Helper\Event\EventType;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EmitOfferNewEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OfferNewEvent';

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Helper command to emit OfferNewEvent for Testing')
            ->addOption('ean', null, InputOption::VALUE_OPTIONAL, 'Offer EAN', null)
            ->addOption('sku', null, InputOption::VALUE_OPTIONAL, 'Offer Sku', null)
            ->addOption('title', null, InputOption::VALUE_OPTIONAL, 'Offer Title', null)
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Offer Price', null)
            ->addOption('quantity', null, InputOption::VALUE_OPTIONAL, 'Offer Quantity', 5);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $this->prepareEventData($input, $output);
        $container = $this->buildEventContainer(EventType::SellerOfferNew(), $event);
        $this->emit($container, $input, $output);
    }
}
