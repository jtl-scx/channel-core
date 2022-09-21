<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\CreateSeller;

/**
 * Class CreateSellerRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Seller\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Request\CreateSellerRequest
 */
class CreateSellerRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $bodyStr = uniqid('body', true);
        $createSellerMock = $this->createMock(CreateSeller::class);
        $createSellerMock->expects($this->atLeastOnce())->method('__toString')->willReturn($bodyStr);

        $request = new CreateSellerRequest($createSellerMock);
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('/v1/channel/seller', $request->getUrl());
        $this->assertSame('POST', $request->getHttpMethod());
    }

    /**
     * @test
     */
    public function it_can_be_build_from_sellerId_and_session(): void
    {
        $sellerId = 'A_SELLER_ID';
        $sesson = 'A_SESSION';
        $sut = CreateSellerRequest::make($sellerId, $sesson);

        $expecation = <<<JSON
{
    "session": "A_SESSION",
    "sellerId": "A_SELLER_ID"
}
JSON;
        self::assertEquals($expecation, $sut->getBody());
    }
}
