<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteCategoryAttributesRequest
 */
class DeleteCategoryAttributesRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_build_correct_url(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals('/v1/channel/attribute/category{?categoryId}', $sut->getUrl());
    }

    /**
     * @test
     */
    public function it_use_correct_parameters(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals(['categoryId' => "A_CATEGORY_ID"], $sut->getParams());
    }

    /**
     * @test
     */
    public function it_use_correct_Http_method(): void
    {
        $sut = new DeleteCategoryAttributesRequest("A_CATEGORY_ID");
        self::assertEquals('DELETE', $sut->getHttpMethod());
    }
}
