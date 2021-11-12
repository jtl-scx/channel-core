<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderShippingEvent extends AbstractEvent
{
    private SellerEventOrderShipping $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderShipping $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderShipping(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderShipping
    {
        return $this->event;
    }
}
