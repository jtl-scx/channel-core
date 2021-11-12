<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList;

/**
 * Class CreateSellerAttributesRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Attribute\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateSellerAttributesRequest
 */
class CreateSellerAttributesRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $bodyStr = uniqid('body', true);
        $sellerId = uniqid('catId', true);

        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->once())->method('__toString')->willReturn($bodyStr);

        $request = new CreateSellerAttributesRequest($sellerId, $attrList);

        $this->assertSame($sellerId, $request->getSellerId());
        $this->assertSame(['sellerId' => $sellerId], $request->getParams());
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/attribute/seller/{sellerId}', $request->getUrl());
    }
}
