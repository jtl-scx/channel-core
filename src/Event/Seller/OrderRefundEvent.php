<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/22
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderRefund;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\RefundIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class OrderRefundEvent extends AbstractEvent implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage, RefundIdRelatedMessage
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

    public function getChannelOrderId(): string
    {
        return $this->getEvent()->getOrderId();
    }

    public function getRefundId(): string
    {
        return $this->getEvent()->getRefundId();
    }

    public function getSellerId(): ChannelSellerId
    {
        return new ChannelSellerId($this->getEvent()->getSellerId());
    }
}
