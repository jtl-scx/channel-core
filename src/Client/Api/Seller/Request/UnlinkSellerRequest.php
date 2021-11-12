<?php


namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class UnlinkSellerRequest extends AbstractScxApiRequest
{
    private string $sellerId;
    private ?string $reason;

    public function __construct(string $sellerId, string $reason = null)
    {
        $this->sellerId = $sellerId;
        $this->reason = $reason;
    }

    public function getUrl(): string
    {
        return '/v1/channel/seller/{sellerId}{?reason}';
    }

    public function getParams(): array
    {
        return [
            'sellerId' => $this->sellerId,
            'reason' => $this->reason,
        ];
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_DELETE;
    }
}
