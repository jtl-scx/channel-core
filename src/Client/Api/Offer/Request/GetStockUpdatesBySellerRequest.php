<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class GetStockUpdatesBySellerRequest extends AbstractScxApiRequest
{
    public function __construct(
        private readonly \DateTime $updatedAfter,
        private readonly string $sellerId
    ) {
    }

    public function getParams(): array
    {
        return [
            'updatedAfter' => $this->updatedAfter->format(\DateTimeInterface::ATOM),
            'sellerId' => $this->sellerId
        ];
    }

    public function getUrl(): string
    {
        return '/v1/channel/offer/stock-updates';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
