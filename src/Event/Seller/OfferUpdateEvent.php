<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/11/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferUpdate;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OfferUpdateEvent extends AbstractEvent
{
    private SellerEventOfferUpdate $eventOfferUpdate;

    public function __construct(
        string $id,
        string $clientVersion,
        \DateTimeImmutable $createdAt,
        SellerEventOfferUpdate $eventOfferUpdate,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerOfferUpdate(), $internalEventId);
        $this->eventOfferUpdate = $eventOfferUpdate;
    }

    public function getEvent(): SellerEventOfferUpdate
    {
        return $this->eventOfferUpdate;
    }
}
