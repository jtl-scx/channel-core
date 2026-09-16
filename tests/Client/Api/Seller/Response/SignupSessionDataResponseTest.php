<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Response\SignupSessionDataResponse::class)]
class SignupSessionDataResponseTest extends TestCase
{
    #[Test]
    public function it_has_a_jtlAccountId(): void
    {
        $sut = new SignupSessionDataResponse(12345678, 0);
        self::assertEquals(12345678, $sut->getJtlAccountId());
    }

    #[Test]
    public function it_consider_http200_as_successful(): void
    {
        $sut = new SignupSessionDataResponse(0, 200);
        self::assertTrue($sut->isSuccessful());
    }
}
