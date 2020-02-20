<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitOfferNewEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OfferNewEvent';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit OfferNewEvent for Testing')
            ->addOption('ean', null, InputOption::VALUE_OPTIONAL, 'Offer EAN', null)
            ->addOption('sku', null, InputOption::VALUE_OPTIONAL, 'Offer Sku', null)
            ->addOption('title', null, InputOption::VALUE_OPTIONAL, 'Offer Title', null)
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Offer Price', null)
            ->addOption('quantity', null, InputOption::VALUE_OPTIONAL, 'Offer Quantity', 5);
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOfferNew();
    }
}
