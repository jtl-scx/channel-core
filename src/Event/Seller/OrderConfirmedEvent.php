<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderAccept;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderConfirmed;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderConfirmedEvent extends AbstractEvent
{
    private SellerEventOrderConfirmed $event;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SellerEventOrderConfirmed $event,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerOrderConfirmed(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderConfirmed
    {
        return $this->event;
    }
}
