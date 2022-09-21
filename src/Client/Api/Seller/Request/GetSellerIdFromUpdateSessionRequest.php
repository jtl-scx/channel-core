<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;

class GetSellerIdFromUpdateSessionRequest extends AbstractScxApiRequest
{
    private string $session;

    public function __construct(string $session)
    {
        $this->session = $session;
    }

    public function getUrl(): string
    {
        return '/v1/channel/seller/update-session{?session}';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_GET;
    }

    public function getParams(): array
    {
        return ['session' => $this->session];
    }
}
