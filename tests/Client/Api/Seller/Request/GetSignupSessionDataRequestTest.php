<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSignupSessionDataRequest
 */
class GetSignupSessionDataRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_use_correct_url(): void
    {
        $sut = new GetSignupSessionDataRequest('');
        self::assertEquals('/v1/channel/seller/signup-session{?session}', $sut->getUrl());
    }

    /**
     * @test
     */
    public function it_use_correct_httpMethod(): void
    {
        $sut = new GetSignupSessionDataRequest('');
        self::assertEquals(ScxApiRequest::HTTP_METHOD_GET, $sut->getHttpMethod());
    }

    /**
     * @test
     */
    public function it_use_correct_params(): void
    {
        $sut = new GetSignupSessionDataRequest('beer');
        self::assertEquals(['session' => 'beer'], $sut->getParams());
    }
}
