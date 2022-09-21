<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OfferEndEvent extends AbstractEvent
{
    private SellerEventOfferEnd $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOfferEnd $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOfferEnd(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOfferEnd
    {
        return $this->event;
    }
}
