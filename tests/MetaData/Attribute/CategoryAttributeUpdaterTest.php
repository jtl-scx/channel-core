<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\CreateCategoryAttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Client\Channel\Api\Attribute\Response\CreateCategoryAttributesResponse;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeMapper;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeUpdaterTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater
 */
class CategoryAttributeUpdaterTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testCanUpdate(): void
    {
        $categoryId = uniqid('categoryId', true);

        $client = Mockery::mock(CreateCategoryAttributesApi::class);
        $mapper = Mockery::mock(CategoryAttributeMapper::class);
        $attributeList = Mockery::mock(CategoryAttributeList::class);
        $response = Mockery::mock(CreateCategoryAttributesResponse::class);

        $mapper->shouldReceive('map')
            ->once()
            ->with($attributeList)
            ->andReturn([]);

        $client->shouldReceive('createCategoryAttributes')
            ->once()
            ->with(Mockery::type(CreateCategoryAttributesRequest::class))
            ->andReturn($response);

        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(201);

        $updater = new CategoryAttributeUpdater($client, $mapper);
        $updater->update($categoryId, $attributeList);
        $this->assertTrue(true);
    }

    public function testFailUpdate(): void
    {
        $categoryId = uniqid('categoryId', true);

        $client = Mockery::mock(CreateCategoryAttributesApi::class);
        $mapper = Mockery::mock(CategoryAttributeMapper::class);
        $attributeList = Mockery::mock(CategoryAttributeList::class);
        $response = Mockery::mock(CreateCategoryAttributesResponse::class);

        $mapper->shouldReceive('map')
            ->once()
            ->with($attributeList)
            ->andReturn([]);

        $client->shouldReceive('createCategoryAttributes')
            ->once()
            ->with(Mockery::type(CreateCategoryAttributesRequest::class))
            ->andReturn($response);

        $response->shouldReceive('getStatusCode')
            ->twice()
            ->andReturn(500);

        $updater = new CategoryAttributeUpdater($client, $mapper);
        $this->expectException(UnexpectedStatusExceprion::class);
        $updater->update($categoryId, $attributeList);
    }
}
