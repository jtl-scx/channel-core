<?php

namespace JTL\SCX\Lib\Channel\Client\Api;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer::class)]
class ChannelApiResponseDeserializerTest extends TestCase
{
    #[Test]
    public function it_can_deserialize_a_ResponseInterface(): void
    {
        $sut = new ChannelApiResponseDeserializer();

        $responseJson = <<<JSON
{
    "channel": "bar",
    "sellerId": "foo"
}
JSON;

        $stream = $this->createStub(StreamInterface::class);
        $stream->method('getContents')->willReturn($responseJson);

        $response = $this->createStub(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);

        /** @var SellerEventTest $expectation */
        $expectation = $sut->deserialize($response, SellerEventTest::class);

        self::assertInstanceOf(SellerEventTest::class, $expectation);
        self::assertEquals("bar", $expectation->getChannel());
        self::assertEquals("foo", $expectation->getSellerId());
    }

    #[Test]
    public function it_can_deserialize_raw_data(): void
    {
        $sut = new ChannelApiResponseDeserializer();

        $data = new stdClass();
        $data->channel = "bar";
        $data->sellerId = "foo";


        /** @var SellerEventTest $expectation */
        $expectation = $sut->deserializeObject($data, SellerEventTest::class);

        self::assertInstanceOf(SellerEventTest::class, $expectation);
        self::assertEquals("bar", $expectation->getChannel());
        self::assertEquals("foo", $expectation->getSellerId());
    }
}
