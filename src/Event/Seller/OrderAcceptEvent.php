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
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderAcceptEvent extends AbstractEvent
{
    private SellerEventOrderAccept $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderAccept $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderAccept(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderAccept
    {
        return $this->event;
    }
}
