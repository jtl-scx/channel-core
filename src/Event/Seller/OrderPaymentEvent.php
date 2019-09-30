<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventOrderPayment;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderPaymentEvent extends AbstractEvent
{
    /**
     * @var SellerEventOrderPayment
     */
    private $event;

    /**
     * OrderPaymentEvent constructor.
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $type
     * @param SellerEventOrderPayment $event
     */
    public function __construct(string $id, \DateTimeImmutable $createdAt, string $type, SellerEventOrderPayment $event)
    {
        parent::__construct($id, $createdAt, $type);
        $this->event = $event;
    }

    /**
     * @return SellerEventOrderPayment
     */
    public function getEvent(): SellerEventOrderPayment
    {
        return $this->event;
    }
}
