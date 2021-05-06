<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerOfferIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class SendOfferListingSuccessfulMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, SellerOfferIdRelatedMessage, ChannelOfferIdRelatedMessage
{
    private ChannelSellerId $sellerId;
    private int $sellerOfferId;
    private string $channelOfferId;
    private ?string $listingUrl;
    private \DateTime $listedAt;

    public function __construct(
        ChannelSellerId $sellerId,
        int $sellerOfferId,
        string $channelOfferId,
        string $listingUrl = null,
        \DateTime $listedAt = null,
        string $messageId = null
    ) {
        parent::__construct($messageId);

        $this->sellerId = $sellerId;
        $this->sellerOfferId = $sellerOfferId;
        $this->channelOfferId = $channelOfferId;
        $this->listingUrl = $listingUrl;
        $this->listedAt = $listedAt ?? new \DateTime();
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getSellerOfferId(): int
    {
        return $this->sellerOfferId;
    }

    public function getChannelOfferId(): string
    {
        return $this->channelOfferId;
    }

    public function getListingUrl(): ?string
    {
        return $this->listingUrl;
    }

    public function getListedAt(): \DateTime
    {
        return $this->listedAt;
    }
}
