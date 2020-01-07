<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class OrderShippingEvent extends AbstractEvent
{
    /**
     * @var OrderShippingEvent
     */
    private $event;

    /**
     * SellerEventOrderShippingEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventOrderShipping $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventOrderShipping $event)
    {
        parent::__construct($id, $createdAt, EventType::SELLER__ORDER_SHIPPING());
        $this->event = $event;
    }

    /**
     * @return SellerEventOrderShipping
     */
    public function getEvent(): SellerEventOrderShipping
    {
        return $this->event;
    }
}
