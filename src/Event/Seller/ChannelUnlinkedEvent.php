<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventChannelUnlinked;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class ChannelUnlinkedEvent extends AbstractEvent
{
    private SellerEventChannelUnlinked $event;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SellerEventChannelUnlinked $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerChannelUnlinked(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventChannelUnlinked
    {
        return $this->event;
    }
}
