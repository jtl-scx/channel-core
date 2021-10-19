<?php

namespace JTL\SCX\Lib\Channel\Order\Refunds;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Client\Channel\Model\ReturnAnnouncement;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class SendAnnouncedReturnMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage
{
    private ReturnAnnouncement $returnAnnouncement;

    public function __construct(
        ReturnAnnouncement $returnAnnouncement,
        string $messageId = null
    ) {
        parent::__construct($messageId);
        $this->returnAnnouncement = $returnAnnouncement;
    }

    public function getSellerId(): ChannelSellerId
    {
        return new ChannelSellerId($this->returnAnnouncement->getSellerId());
    }

    public function getChannelOrderId(): string
    {
        return $this->returnAnnouncement->getOrderId();
    }

    public function getReturnAnnouncement(): ReturnAnnouncement
    {
        return $this->returnAnnouncement;
    }
}
