<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList;

class CreateCategoryAttributesRequest extends AbstractScxApiRequest
{
    private string $categoryId;

    private AttributeList $attributeList;

    public function __construct(string $categoryId, AttributeList $attributeList)
    {
        $this->categoryId = $categoryId;
        $this->attributeList = $attributeList;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getParams(): array
    {
        return ['categoryId' => $this->getCategoryId()];
    }

    public function getBody(): ?string
    {
        return (string)$this->attributeList;
    }

    public function getUrl(): string
    {
        return '/v1/channel/attribute/category/{categoryId}';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PUT;
    }
}
