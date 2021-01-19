<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;


use DateTimeImmutable;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\OrderAccept;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderAcceptEvent extends AbstractEvent
{
    private OrderAccept $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        OrderAccept $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderAccept(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): OrderAccept
    {
        return $this->event;
    }
}
