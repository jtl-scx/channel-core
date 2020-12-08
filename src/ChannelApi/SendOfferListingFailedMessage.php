<?php declare(strict_types=1);
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

class SendOfferListingFailedMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, SellerOfferIdRelatedMessage
{
    private ChannelSellerId $sellerId;
    private string $sellerOfferId;
    private \DateTime $failedAt;
    private ListingFailedErrorList $errorList;

    public function __construct(
        ChannelSellerId $sellerId,
        string $sellerOfferId,
        string $errorCode,
        string $errorMessage,
        \DateTime $failedAt = null,
        string $messageId = null
    ) {
        parent::__construct($messageId);

        $this->sellerId = $sellerId;
        $this->sellerOfferId = $sellerOfferId;
        $this->errorList = new ListingFailedErrorList();
        $this->errorList->add(new ListingFailedError($errorCode, $errorMessage));
        $this->failedAt = $failedAt ?? new \DateTime();
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getSellerOfferId(): string
    {
        return $this->sellerOfferId;
    }

    public function addError(string $errorCode, string $errorMessage, string $errorLongMessage = null): void
    {
        $this->errorList->add(new ListingFailedError($errorCode, $errorMessage, $errorLongMessage));
    }

    public function getErrorList(): ListingFailedErrorList
    {
        return $this->errorList;
    }

    public function getFailedAt(): \DateTime
    {
        return $this->failedAt;
    }
}
