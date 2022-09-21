<?php

declare(strict_types=1);
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
 * Class CreateCategoryAttributesRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Attribute\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateCategoryAttributesRequest
 */
class CreateCategoryAttributesRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $bodyStr = uniqid('body', true);
        $categoryId = uniqid('catId', true);

        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->once())->method('__toString')->willReturn($bodyStr);

        $request = new CreateCategoryAttributesRequest($categoryId, $attrList);

        $this->assertSame(['categoryId' => $categoryId], $request->getParams());
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/attribute/category/{categoryId}', $request->getUrl());
    }
}
