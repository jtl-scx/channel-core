<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSignupSessionDataRequest::class)]
class GetSignupSessionDataRequestTest extends TestCase
{
    #[Test]
    public function it_use_correct_url(): void
    {
        $sut = new GetSignupSessionDataRequest('');
        self::assertEquals('/v1/channel/seller/signup-session{?session}', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_httpMethod(): void
    {
        $sut = new GetSignupSessionDataRequest('');
        self::assertEquals(ScxApiRequest::HTTP_METHOD_GET, $sut->getHttpMethod());
    }

    #[Test]
    public function it_use_correct_params(): void
    {
        $sut = new GetSignupSessionDataRequest('beer');
        self::assertEquals(['session' => 'beer'], $sut->getParams());
    }
}
