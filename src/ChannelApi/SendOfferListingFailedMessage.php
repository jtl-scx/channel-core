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

class SendOfferListingFailedMessage extends AbstractAmqpTransportableMessage implements
    SellerIdRelatedMessage,
    SellerOfferIdRelatedMessage
{
    private ChannelSellerId $sellerId;
    private int $sellerOfferId;
    private \DateTime $failedAt;
    private ListingFailedErrorList $errorList;

    public function __construct(
        ChannelSellerId $sellerId,
        int $sellerOfferId,
        string $errorCode,
        string $errorMessage,
        \DateTime $failedAt = null,
        string $messageId = null
    ) {
        parent::__construct($messageId);

        $this->sellerId = $sellerId;
        $this->sellerOfferId = $sellerOfferId;
        $this->errorList = new ListingFailedErrorList();

        $details = null;
        if (mb_strlen($errorMessage) > 250) {
            $details = $errorMessage;
            $errorMessage = mb_substr($errorMessage, 0, 250);
        }

        $this->errorList->add(new ListingFailedError($errorCode, $errorMessage, $details));
        $this->failedAt = $failedAt ?? new \DateTime();
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getSellerOfferId(): int
    {
        return $this->sellerOfferId;
    }

    public function addError(string $errorCode, string $errorMessage, string $errorLongMessage = null): void
    {
        if (strlen($errorMessage) > 250) {
            $errorLongMessage = "{$errorLongMessage}\n{$errorMessage}";
            $errorMessage = substr($errorMessage, 0, 250);
        }
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
