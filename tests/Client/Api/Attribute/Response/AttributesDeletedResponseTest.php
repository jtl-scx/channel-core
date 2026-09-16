<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/18/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Attribute\Response\AttributesDeletedResponse::class)]
class AttributesDeletedResponseTest extends TestCase
{
    public function testCanCheckIfSuccessful()
    {
        $response = new AttributesDeletedResponse(204);
        $this->assertTrue($response->isSuccessful());
    }

    public function testStatusCodeNotEquals204IsConsideredAsRequestFailed()
    {
        $response = new AttributesDeletedResponse(201);
        $this->assertFalse($response->isSuccessful());
    }
}
