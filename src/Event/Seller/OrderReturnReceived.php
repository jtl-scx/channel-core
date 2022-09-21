<?php

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderReturnReceived;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class OrderReturnReceived extends AbstractEvent implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage
{
    private SellerEventOrderReturnReceived $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderReturnReceived $type,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderReturnReceived(), $internalEventId);
        $this->event = $type;
    }


    public function getEvent(): SellerEventOrderReturnReceived
    {
        return $this->event;
    }


    public function getSellerId(): ChannelSellerId
    {
        return new ChannelSellerId($this->getEvent()->getSellerId());
    }

    public function getChannelOrderId(): string
    {
        return $this->getEvent()->getOrderId();
    }
}
