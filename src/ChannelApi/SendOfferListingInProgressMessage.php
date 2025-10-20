<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class SendOfferListingInProgressMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, SellerOfferIdRelatedMessage
{
    private ChannelSellerId $sellerId;

    private int $sellerOfferId;

    private \DateTime $startedAt;

    public function __construct(
        ChannelSellerId $sellerId,
        int $sellerOfferId,
        \DateTime|null $startedAt = null,
        string|null $messageId = null
    ) {
        parent::__construct($messageId);

        $this->sellerId = $sellerId;
        $this->sellerOfferId = $sellerOfferId;
        $this->startedAt = $startedAt ?? new \DateTime();
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getSellerOfferId(): int
    {
        return $this->sellerOfferId;
    }

    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }
}
