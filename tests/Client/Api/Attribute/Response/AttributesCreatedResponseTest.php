<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/18/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Attribute\Response\AttributesCreatedResponse
 */
class AttributesCreatedResponseTest extends TestCase
{
    public function testCanCheckIfSuccessful()
    {
        $response = new AttributesCreatedResponse(201);
        $this->assertTrue($response->isSuccessful());
    }

    public function testStatusCodeNotEquals204IsConsideredAsRequestFailed()
    {
        $response = new AttributesCreatedResponse(211);
        $this->assertFalse($response->isSuccessful());
    }
}
