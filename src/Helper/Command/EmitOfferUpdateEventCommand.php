<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'helper:emit.OfferUpdateEvent')]
class EmitOfferUpdateEventCommand extends EmitOfferNewEventCommand
{
    protected function getEventType(): EventType
    {
        return EventType::SellerOfferUpdate();
    }
}
