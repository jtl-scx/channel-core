<?php

namespace JTL\SCX\Lib\Channel\Seller;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;

class UnlinkSellerMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage
{
    private ChannelSellerId $channelSellerId;
    private ?string $reason;

    public function __construct(ChannelSellerId $channelSellerId, string $reason = null, string $messageId = null)
    {
        parent::__construct($messageId);
        $this->channelSellerId = $channelSellerId;
        $this->reason = $reason;
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->channelSellerId;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }
}
