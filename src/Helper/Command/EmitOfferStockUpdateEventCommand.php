<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitOfferStockUpdateEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OfferStockUpdateEvent';

    protected function configure(): void
    {
        parent::configure();
        $this->addOption('offerId', null, InputOption::VALUE_OPTIONAL, 'Seller OfferId', null)
            ->addOption('quantity', null, InputOption::VALUE_OPTIONAL, 'Offer Quantity', '5');
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOfferStockUpdate();
    }
}
