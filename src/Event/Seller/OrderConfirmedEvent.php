<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\SellerEventOrderConfirmed;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderConfirmedEvent extends AbstractEvent
{
    private SellerEventOrderConfirmed $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderConfirmed $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderConfirmed(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderConfirmed
    {
        return $this->event;
    }
}
