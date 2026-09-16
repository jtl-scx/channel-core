<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Category\Request\UpdateCategoryTreeRequest;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\CategoryTreeVersion;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CategoryApiTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Category
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Category\CategoryApi::class)]
class CategoryApiTest extends TestCase
{
    public function testUpdateCategoryTree()
    {
        $status = 201;
        $requestMock = $this->createStub(UpdateCategoryTreeRequest::class);
        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);
        $categoryTreeVersionMock = $this->createStub(CategoryTreeVersion::class);

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
