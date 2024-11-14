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
    private \DateTime $failedAt;
    private ListingFailedErrorList $errorList;

    public function __construct(
        private readonly ChannelSellerId $sellerId,
        private readonly int $sellerOfferId,
        string $errorCode,
        string $errorMessage,
        \DateTime $failedAt = null,
        string $messageId = null,
        string|null $relatedAttributeId = null,
        string|null $recommendedValue = null,
    ) {
        parent::__construct($messageId);

        $this->errorList = new ListingFailedErrorList();
        $this->addError(
            errorCode: $errorCode,
            errorMessage: $errorMessage,
            relatedAttributeId: $relatedAttributeId,
            recommendedValue: $recommendedValue
        );
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

    public function addError(
        string $errorCode,
        string $errorMessage,
        string|null $errorLongMessage = null,
        string|null $relatedAttributeId = null,
        string|null $recommendedValue = null,
    ): void {
        if (mb_strlen($errorMessage) > 250) {
            if ($errorLongMessage === null) {
                $errorLongMessage = $errorMessage;
            } else {
                $errorLongMessage = "{$errorLongMessage}\n{$errorMessage}";
            }
            $errorMessage = mb_substr($errorMessage, 0, 250);
        }

        $this->errorList->add(
            new ListingFailedError(
                code: $errorCode,
                message: $errorMessage,
                longMessage: $errorLongMessage,
                relatedAttributeId: $relatedAttributeId,
                recommendedValue: $recommendedValue
            )
        );
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
