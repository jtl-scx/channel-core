<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/22
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\SellerEventOrderRefund;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderRefundEvent extends AbstractEvent
{
    private SellerEventOrderRefund $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderRefund $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerEventOrderRefund(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventOrderRefund
    {
        return $this->event;
    }
}
