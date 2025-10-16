<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OfferNewEvent extends AbstractEvent
{
    private SellerEventOfferNew $eventOfferNew;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SellerEventOfferNew $eventOfferNew,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerOfferNew(), $internalEventId);
        $this->eventOfferNew = $eventOfferNew;
    }

    public function getEvent(): SellerEventOfferNew
    {
        return $this->eventOfferNew;
    }
}
