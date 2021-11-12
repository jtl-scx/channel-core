<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Model\UpdateSeller;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UpdateSellerRequest
 */
class UpdateSellerRequestTest extends TestCase
{

    /**
     * @test
     */
    public function it_use_correct_url(): void
    {
        $sut = new UpdateSellerRequest(self::createStub(UpdateSeller::class));
        self::assertEquals('/v1/channel/seller', $sut->getUrl());
    }

    /**
     * @test
     */
    public function it_use_correct_httpMethod(): void
    {
        $sut = new UpdateSellerRequest(self::createStub(UpdateSeller::class));
        self::assertEquals(ScxApiRequest::HTTP_METHOD_PATCH, $sut->getHttpMethod());
    }

    /**
     * @test
     */
    public function it_use_correct_body(): void
    {
        $updateSeller = self::createStub(UpdateSeller::class);
        $updateSeller->method('__toString')->willReturn('THIS_IS_JSON');
        $sut = new UpdateSellerRequest($updateSeller);
        self::assertEquals('THIS_IS_JSON', $sut->getBody());
    }
}
