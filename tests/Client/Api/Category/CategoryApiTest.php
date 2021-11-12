<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Category\Request\UpdateCategoryTreeRequest;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\CategoryTreeVersion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CategoryApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Category
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Category\CategoryApi
 */
class CategoryApiTest extends TestCase
{
    public function testUpdateCategoryTree()
    {
        $status = 201;
        $requestMock = $this->createMock(UpdateCategoryTreeRequest::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);
        $categoryTreeVersionMock = $this->createMock(CategoryTreeVersion::class);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);
        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);
        $serializerMock->expects($this->once())->method('deserialize')->with($responseMock)->willReturn($categoryTreeVersionMock);

        $client = new CategoryApi($apiClientMock, $serializerMock);
        $response = $client->updateCategoryTree($requestMock);

        $this->assertSame($status, $response->getStatusCode());
        $this->assertSame($categoryTreeVersionMock, $response->getCategoryTreeVersion());
    }
}
