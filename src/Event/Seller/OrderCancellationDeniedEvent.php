<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/3/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationDenied;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderCancellationDeniedEvent extends AbstractEvent
{
    private SellerEventOrderCancellationDenied $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderCancellationDenied $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderCancellationDenied(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderCancellationDenied
    {
        return $this->event;
    }
}
