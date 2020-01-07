<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOrderCancelled;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class OrderCancelledEvent extends AbstractEvent
{
    /**
     * @var SellerEventOrderCancelled
     */
    private $event;

    /**
     * OrderCancelledEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventOrderCancelled $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventOrderCancelled $event)
    {
        parent::__construct($id, $createdAt, EventType::SELLER__ORDER_CANCELLED());
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
