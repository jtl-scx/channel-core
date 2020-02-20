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
use JTL\SCX\Client\Channel\Model\SellerEventOrderCancelled;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderCancelledEvent extends AbstractEvent
{
    private SellerEventOrderCancelled $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderCancelled $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderCancelled(), $internalEventId);
        $this->event = $event;
    }

    /**
     * @return SellerEventOrderCancelled
     */
    public function getEvent(): SellerEventOrderCancelled
    {
        return $this->event;
    }
}
