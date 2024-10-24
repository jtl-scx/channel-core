<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

class ListingFailedError
{
    public function __construct(
        private string $code,
        private string $message,
        private string|null $longMessage = null,
        private string|null $relatedAttributeId = null,
        private string|null $recommendedValue = null,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLongMessage(): ?string
    {
        return $this->longMessage;
    }

    public function getRelatedAttributeId(): ?string
    {
        return $this->relatedAttributeId;
    }

    public function getRecommendedValue(): ?string
    {
        return $this->recommendedValue;
    }
}
