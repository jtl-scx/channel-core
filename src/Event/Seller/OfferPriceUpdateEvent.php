<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\SellerEventOfferPriceUpdate;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OfferPriceUpdateEvent extends AbstractEvent
{
    private SellerEventOfferPriceUpdate $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOfferPriceUpdate $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOfferPriceUpdate(), $internalEventId);

        $this->event = $event;
    }

    public function getEvent(): SellerEventOfferPriceUpdate
    {
        return $this->event;
    }
}
