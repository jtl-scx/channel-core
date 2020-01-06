<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\CreateCategoryAttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateCategoryAttributesRequest;
use JTL\SCX\Client\Channel\Api\Attribute\Response\CreateCategoryAttributesResponse;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeUpdaterTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater
 */
class CategoryAttributeUpdaterTest extends TestCase
{
    public function testCanUpdate(): void
    {
        $categoryId = uniqid('categoryId', true);

        $clientMock = $this->createMock(CreateCategoryAttributesApi::class);
        $mapperMock = $this->createMock(AttributeMapper::class);
        $attributeList = $this->createMock(AttributeList::class);
        $responseMock = $this->createMock(CreateCategoryAttributesResponse::class);

        $mapperMock->expects($this->once())->method('map')->with($attributeList)->willReturn([]);

        $clientMock->expects($this->once())->method('createCategoryAttributes')
            ->with($this->isInstanceOf(CreateCategoryAttributesRequest::class))
            ->willReturn($responseMock);

        $responseMock->expects($this->once())->method('getStatusCode')->willReturn(201);

        $updater = new CategoryAttributeUpdater($clientMock, $mapperMock);
        $updater->update($categoryId, $attributeList);
    }

    public function testFailUpdate(): void
    {
        $categoryId = uniqid('categoryId', true);

        $clientMock = $this->createMock(CreateCategoryAttributesApi::class);
        $mapperMock = $this->createMock(AttributeMapper::class);
        $attributeList = $this->createMock(AttributeList::class);
        $responseMock = $this->createMock(CreateCategoryAttributesResponse::class);

        $mapperMock->expects($this->once())->method('map')->with($attributeList)->willReturn([]);

        $clientMock->expects($this->once())->method('createCategoryAttributes')
            ->with($this->isInstanceOf(CreateCategoryAttributesRequest::class))
            ->willReturn($responseMock);

        $responseMock->expects($this->any())->method('getStatusCode')->willReturn(500);

        $updater = new CategoryAttributeUpdater($clientMock, $mapperMock);

        $this->expectException(UnexpectedStatusException::class);
        $updater->update($categoryId, $attributeList);
    }
}
