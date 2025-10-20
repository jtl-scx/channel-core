<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/3/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationAccepted;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderCancellationAcceptedEvent extends AbstractEvent
{
    private SellerEventOrderCancellationAccepted $event;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SellerEventOrderCancellationAccepted $event,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerOrderCancellationAccept(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderCancellationAccepted
    {
        return $this->event;
    }
}
