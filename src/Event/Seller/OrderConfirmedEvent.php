<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOrderConfirmed;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class OrderConfirmedEvent extends AbstractEvent
{
    /**
     * @var SellerEventOrderConfirmed
     */
    private $event;

    /**
     * OrderConfirmedEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventOrderConfirmed $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventOrderConfirmed $event)
    {
        parent::__construct($id, $createdAt, EventType::SELLER__ORDER_CONFIRMED());
        $this->event = $event;
    }

    /**
     * @return SellerEventOrderConfirmed
     */
    public function getEvent(): SellerEventOrderConfirmed
    {
        return $this->event;
    }
}
