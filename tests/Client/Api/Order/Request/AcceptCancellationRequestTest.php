<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/12/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Order\Request\AcceptCancellationRequest::class)]
class AcceptCancellationRequestTest extends TestCase
{
    #[Test]
    public function it_has_correct_url(): void
    {
        $sut = new AcceptCancellationRequest('', '');
        $this->assertEquals('/v1/channel/order/cancellation-accept', $sut->getUrl());
    }

    #[Test]
    public function it_use_correct_http_method(): void
    {
        $sut = new AcceptCancellationRequest('', '');
        $this->assertEquals(DenyCancellationRequest::HTTP_METHOD_PUT, $sut->getHttpMethod());
    }

    #[Test]
    public function it_can_render_request_body(): void
    {
        $sut = new AcceptCancellationRequest('A_SELLER', 'A_ID');
        $this->assertEquals(
            json_encode(
                [
                    'sellerId' => 'A_SELLER',
                    'orderCancellationRequestId' => 'A_ID'
                ],
                JSON_PRETTY_PRINT
            ),
            $sut->getBody()
        );
    }
}
