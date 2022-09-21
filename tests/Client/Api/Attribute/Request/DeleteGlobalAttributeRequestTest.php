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

/**
 * Class DeleteGlobalAttributeRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Attribute\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\DeleteGlobalAttributeRequest
 */
class DeleteGlobalAttributeRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $bodyStr = uniqid('body', true);

        $attrId = uniqid('attrId', true);

        $request = new DeleteGlobalAttributeRequest($attrId);

        $this->assertSame(['attributeId' => $attrId], $request->getParams());
        $this->assertSame('DELETE', $request->getHttpMethod());
        $this->assertSame('/v1/channel/attribute/global/{attributeId}', $request->getUrl());
    }
}
