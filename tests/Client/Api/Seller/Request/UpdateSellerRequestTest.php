<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Client\Model\UpdateSeller;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UpdateSellerRequest::class)]
class UpdateSellerRequestTest extends TestCase
{
    #[Test]
    public function it_use_correct_url(): void
    {
        $sut = new UpdateSellerRequest(self::createStub(UpdateSeller::class));
        self::assertEquals('/v1/channel/seller', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_httpMethod(): void
    {
        $sut = new UpdateSellerRequest(self::createStub(UpdateSeller::class));
        self::assertEquals(ScxApiRequest::HTTP_METHOD_PATCH, $sut->getHttpMethod());
    }

    #[Test]
    public function it_use_correct_body(): void
    {
        $updateSeller = self::createStub(UpdateSeller::class);
        $updateSeller->method('__toString')->willReturn('THIS_IS_JSON');
        $sut = new UpdateSellerRequest($updateSeller);
        self::assertEquals('THIS_IS_JSON', $sut->getBody());
    }
}
