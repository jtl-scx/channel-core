<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class GetAllStockUpdatesRequest extends AbstractScxApiRequest
{
    public function __construct(private readonly \DateTime $updatedAfter)
    {
    }

    public function getParams(): array
    {
        return ['updatedAfter' => $this->updatedAfter->format(\DateTimeInterface::ATOM)];
    }

    public function getUrl(): string
    {
        return '/v1/channel/offer/stock-updates/all';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
