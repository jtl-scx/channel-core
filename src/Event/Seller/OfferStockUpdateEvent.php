<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferStockUpdate;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OfferStockUpdateEvent extends AbstractEvent
{
    private SellerEventOfferStockUpdate $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOfferStockUpdate $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOfferStockUpdate(), $internalEventId);

        $this->event = $event;
    }

    public function getEvent(): SellerEventOfferStockUpdate
    {
        return $this->event;
    }
}
