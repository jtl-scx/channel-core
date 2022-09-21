<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreateShippingRulesResponse
 */
class CreateShippingRulesResponseTest extends TestCase
{
    public function testIsSuccessful(): void
    {
        $response = new CreateShippingRulesResponse(201);
        $this->assertTrue($response->isSuccessful());
    }

    public function responsCodeProvider(): array
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
     * @dataProvider responsCodeProvider
     */
    public function testIsNotSuccessful($responseCode): void
    {
        $response = new CreateShippingRulesResponse($responseCode);
        $this->assertFalse($response->isSuccessful());
    }
}
