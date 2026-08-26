<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\Response\PutSellerShippingRulesResponse
 */
class PutSellerShippingRulesResponseTest extends TestCase
{
    public function testIsSuccessful(): void
    {
        $response = new PutSellerShippingRulesResponse(201);
        $this->assertTrue($response->isSuccessful());
    }

    public function responseCodeProvider(): array
    {
        return [
            [200],
            [202],
            [0],
            [300],
            [random_int(202, 599)],
            [random_int(1, 200)],
        ];
    }

    /**
     * @dataProvider responseCodeProvider
     */
    public function testIsNotSuccessful($responseCode): void
    {
        $response = new PutSellerShippingRulesResponse($responseCode);
        $this->assertFalse($response->isSuccessful());
    }
}
