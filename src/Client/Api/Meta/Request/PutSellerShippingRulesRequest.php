<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Client\Request\ScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerShippingRules;

/**
 * EA-8054: Set seller specific channel shipping attributes for a single seller connected to this channel.
 */
class PutSellerShippingRulesRequest extends AbstractScxApiRequest
{
    public function __construct(
        private readonly string $sellerId,
        private readonly SellerShippingRules $sellerShippingRules
    ) {
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getSellerShippingRules(): SellerShippingRules
    {
        return $this->sellerShippingRules;
    }

    public function getUrl(): string
    {
        return '/v1/channel/shipping-rules/{sellerId}';
    }

    public function getParams(): array
    {
        return [
            'sellerId' => $this->sellerId,
        ];
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_PUT;
    }

    public function getBody(): string
    {
        return (string)$this->sellerShippingRules;
    }
}
