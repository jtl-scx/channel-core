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

class DeleteCategoryAttributesRequest extends AbstractScxApiRequest
{
    private string $categoryId;

    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getUrl(): string
    {
        return '/v1/channel/attribute/category{?categoryId}';
    }

    public function getParams(): array
    {
        return ['categoryId' => $this->categoryId];
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_DELETE;
    }
}
