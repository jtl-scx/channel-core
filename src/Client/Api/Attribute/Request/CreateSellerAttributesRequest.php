<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList;

class CreateSellerAttributesRequest extends AbstractScxApiRequest
{
    private string $sellerId;

    private AttributeList $attributeList;

    public function __construct(string $sellerId, AttributeList $attributeList)
    {
        $this->sellerId = $sellerId;
        $this->attributeList = $attributeList;
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getParams(): array
    {
        return ['sellerId' => $this->sellerId];
    }

    public function getBody(): ?string
    {
        return (string)$this->attributeList;
    }

    public function getUrl(): string
    {
        return '/v1/channel/attribute/seller/{sellerId}';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PUT;
    }
}
