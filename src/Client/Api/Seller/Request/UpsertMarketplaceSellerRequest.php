<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Client\Request\ScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\UpsertMarketplaceSeller;

class UpsertMarketplaceSellerRequest extends AbstractScxApiRequest
{
    public function __construct(
        private readonly int $jtlAccountId,
        private readonly UpsertMarketplaceSeller $upsertMarketplaceSeller
    ) {
    }

    public static function make(int $jtlAccountId, string $sellerId, bool $isActive = true, string $companyName = ''): UpsertMarketplaceSellerRequest
    {
        return new self($jtlAccountId, new UpsertMarketplaceSeller([
            'sellerId' => $sellerId,
            'isActive' => $isActive,
            'companyName' => $companyName,
        ]));
    }

    public function getUrl(): string
    {
        return '/v1/channel/seller/platform/{jtlAccountId}';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }

    public function getUpsertMarketplaceSellerModel(): UpsertMarketplaceSeller
    {
        return $this->upsertMarketplaceSeller;
    }

    /**
     * @return string[]
     */
    public function getParams(): array
    {
        return [
            'jtlAccountId' => $this->jtlAccountId,
        ];
    }

    public function getBody(): string
    {
        return (string)$this->getUpsertMarketplaceSellerModel();
    }
}
