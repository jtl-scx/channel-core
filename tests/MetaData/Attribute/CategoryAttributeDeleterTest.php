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
        $testCategoryId = 'A_CATEGORY_ID';

        $api = $this->createMock(AttributesApi::class);
        $response = $this->createMock(AttributesDeletedResponse::class);

        $api->expects(self::once())
            ->method('deleteCategoryAttributes')
            ->with($testCategoryId)
            ->willReturn($response);

        $response->expects(self::once())
            ->method('isSuccessful')
            ->willReturn(true);

        $deleter = new CategoryAttributeDeleter($api);
        $deleter->delete($testCategoryId);
    }

    /**
     * @test
     */
    public function failIfApiDoesNotReturnHttp201(): void
    {
        $testCategoryId = 'A_CATEGORY_ID';

        $api = $this->createMock(AttributesApi::class);
        $response = $this->createMock(AttributesDeletedResponse::class);

        $api->expects(self::once())
            ->method('deleteCategoryAttributes')
            ->with($testCategoryId)
            ->willReturn($response);

        $response->expects(self::once())
            ->method('isSuccessful')
            ->willReturn(false);

        $deleter = new CategoryAttributeDeleter($api);
        $this->expectException(UnexpectedStatusException::class);
        $deleter->delete($testCategoryId);
    }
}
