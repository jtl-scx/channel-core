<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/17
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderShippingEvent extends AbstractEvent
{
    /**
     * @var OrderShippingEvent
     */
    private $event;

    /**
     * SellerEventOrderShippingEvent constructor.
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $type
     * @param SellerEventOrderShipping $event
     */
    public function __construct(
        string $id,
        \DateTimeImmutable $createdAt,
        string $type,
        SellerEventOrderShipping $event
    ) {
        parent::__construct($id, $createdAt, $type);
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
