<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 9/1/21
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\DeleteCategoryAttributesRequest;
use JTL\SCX\Client\Channel\Api\Attribute\Response\AttributesDeletedResponse;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeDeleter
 *
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeDeleter
 */
class CategoryAttributeDeleterTest extends TestCase
{
    /**
     * @test
     */
    public function canDeleteAttributes(): void
    {
        $api = $this->createMock(AttributesApi::class);
        $response = $this->createMock(AttributesDeletedResponse::class);

        $api->expects(self::once())
            ->method('deleteCategoryAttributes')
            ->with(self::isInstanceOf(DeleteCategoryAttributesRequest::class))
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(201);

        $deleter = new CategoryAttributeDeleter($api);
        $deleter->delete();
    }

    /**
     * @test
     */
    public function failIfApiDoesNotReturnHttp201(): void
    {
        $api = $this->createMock(AttributesApi::class);
        $response = $this->createMock(AttributesDeletedResponse::class);

        $api->expects(self::once())
            ->method('deleteCategoryAttributes')
            ->with(self::isInstanceOf(DeleteCategoryAttributesRequest::class))
            ->willReturn($response);

        $response->expects(self::exactly(2))
            ->method('getStatusCode')
            ->willReturn(random_int(500, 520));

        $deleter = new CategoryAttributeDeleter($api);
        $this->expectException(UnexpectedStatusException::class);
        $deleter->delete();
    }
}
