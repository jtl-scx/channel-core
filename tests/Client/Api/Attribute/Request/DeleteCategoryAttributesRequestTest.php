<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteCategoryAttributesRequest::class)]
class DeleteCategoryAttributesRequestTest extends TestCase
{
    #[Test]
    public function it_build_correct_url(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals('/v1/channel/attribute/category{?categoryId}', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_parameters(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals(['categoryId' => "A_CATEGORY_ID"], $sut->getParams());
    }

    #[Test]
    public function it_use_correct_Http_method(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals('DELETE', $sut->getHttpMethod());
    }
}
