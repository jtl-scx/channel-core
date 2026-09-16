<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Response\UpdateSellerResponse::class)]
class UpdateSellerResponseTest extends TestCase
{
    #[Test]
    public function it_consider_http201_as_successful(): void
    {
        $sut = new UpdateSellerResponse(201);
        self::assertTrue($sut->isSuccessful());

        $sut = new UpdateSellerResponse(200);
        self::assertFalse($sut->isSuccessful());
    }
}
