<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSellerIdFromUpdateSessionRequest::class)]
class GetSellerIdFromUpdateSessionRequestTest extends TestCase
{
    #[Test]
    public function it_use_correct_url(): void
    {
        $sut = new GetSellerIdFromUpdateSessionRequest('');
        self::assertEquals('/v1/channel/seller/update-session{?session}', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_httpMethod(): void
    {
        $sut = new GetSellerIdFromUpdateSessionRequest('');
        self::assertEquals(ScxApiRequest::HTTP_METHOD_GET, $sut->getHttpMethod());
    }

    #[Test]
    public function it_use_correct_params(): void
    {
        $sut = new GetSellerIdFromUpdateSessionRequest('abcd');
        self::assertEquals(['session' => 'abcd'], $sut->getParams());
    }
}
