<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Client\Request\ScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;

class GetSellerListRequest extends AbstractScxApiRequest
{
    public function getUrl(): string
    {
        return '/v1/channel/seller/list';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
