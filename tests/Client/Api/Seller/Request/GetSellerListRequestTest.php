<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Request\GetSellerListRequest::class)]
class GetSellerListRequestTest extends TestCase
{
    public function testCanBeCreatedAndValidated(): void
    {
        $request = new GetSellerListRequest();

        $this->assertSame('/v1/channel/seller/list', $request->getUrl());
        $this->assertSame(ScxApiRequest::HTTP_METHOD_GET, $request->getHttpMethod());
        $this->assertSame([], $request->getParams());
        $this->assertSame('', $request->getBody());
    }
}
