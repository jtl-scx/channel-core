<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\SCX\Client\Channel\Api\Category\Response\UpdateCategoryTreeResponse;
use JTL\SCX\Client\Channel\Api\Category\UpdateCategoryTreeApi;
use JTL\SCX\Client\Channel\Model\CategoryTreeVersion;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryTreeUpdaterTest
 * @package JTL\SCX\Lib\Channel\MetaData
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\CategoryTreeUpdater
 */
class CategoryTreeUpdaterTest extends TestCase
{
    public function testCanUpdate(): void
    {
        $mapper = new CategoryMapper();
        $resultVersion = uniqid('version', true);

        $response = new UpdateCategoryTreeResponse(201,
            new CategoryTreeVersion(['categoryTreeVersion' => $resultVersion]));

        $clientMock = \Mockery::mock(UpdateCategoryTreeApi::class);
        $clientMock->expects('update')->once()->andReturn($response);

        $updater = new CategoryTreeUpdater($clientMock, $mapper);

        $this->assertSame($resultVersion, $updater->update($this->createCategoryList()));
    }

    public function testUpdateCanFail(): void
    {
        $mapper = new CategoryMapper();

        $response = new UpdateCategoryTreeResponse(400, new CategoryTreeVersion());

        $clientMock = \Mockery::mock(UpdateCategoryTreeApi::class);
        $clientMock->expects('update')->once()->andReturn($response);
        $updater = new CategoryTreeUpdater($clientMock, $mapper);

        $this->expectException(\Exception::class);
        $updater->update($this->createCategoryList());
    }

    private function createCategoryList(): CategoryList
    {
        $categoryList = new CategoryList();
        $categoryList[] = new Category(
            '1', '2', '3'
        );
        return $categoryList;
    }
}
