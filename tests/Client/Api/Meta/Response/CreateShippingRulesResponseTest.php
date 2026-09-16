<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreateShippingRulesResponse::class)]
class CreateShippingRulesResponseTest extends TestCase
{
    public function testIsSuccessful(): void
    {
        $response = new CreateShippingRulesResponse(201);
        $this->assertTrue($response->isSuccessful());
    }

    public static function responsCodeProvider(): array
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

    #[DataProvider('responsCodeProvider')]
    public function testIsNotSuccessful($responseCode): void
    {
        $response = new CreateShippingRulesResponse($responseCode);
        $this->assertFalse($response->isSuccessful());
    }
}
