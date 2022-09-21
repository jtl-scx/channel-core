<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-24
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;

class EmitSellerAttributeUpdateCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.SellerAttributeUpdateRequest';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit a SellerAttributeUpdate Request Event');
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerMetaSellerAttributesUpdateRequest();
    }
}
