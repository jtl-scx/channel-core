<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event;

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\GetEventListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Response\AcknowledgeEventIdListResponse;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use JTL\SCX\Client\JsonSerializer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\EventApi
 */
class EventApiTest extends TestCase
{
    public function eventProvider(): array
    {
        return [
            ['System:Notification', SystemEventNotification::class],
            ['System:Test', SellerEventTest::class],
            ['Seller:Order.Shipping', SellerEventOrderShipping::class],
            ['Seller:Order.Payment', SellerEventOrderPayment::class],
            ['Seller:Offer.End', SellerEventOfferEnd::class],
            ['Seller:Offer.New', SellerEventOfferNew::class],
            ['unknown', \stdClass::class, false],
        ];
    }

    /**
     * @dataProvider eventProvider
     */
    public function testCanGetEventList(string $eventType, string $eventClass, bool $isEvent = true)
    {
        $status = 201;
        $eventData = new \stdClass();
        $eventData->id = uniqid('eventId', true);
        $eventData->createdAt = 'now';
        $eventData->type = $eventType;
        $eventData->event = new \stdClass();
        $data = new \stdClass();
        $data->eventList = [
            $eventData
        ];

        $requestMock = $this->createMock(GetEventListRequest::class);

        $jsonContent = uniqid('jsonContent', true);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn($status);
        $responseMock->method('getBody')->willReturn($jsonContent);

        $eventMock = $this->createMock($eventClass);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')->with($requestMock)->willReturn($responseMock);
        $jsonDeserializerMock = $this->createMock(JsonSerializer::class);
        $jsonDeserializerMock->expects($this->once())->method('deserialize')->with($jsonContent)->willReturn($data);
        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);
        $serializerMock->expects($this->exactly($isEvent ? 1 : 0))->method('deserializeObject')->with(
            $eventData->event,
            $eventClass
        )->willReturn($eventMock);

        $client = new EventApi($apiClientMock, $jsonDeserializerMock, $serializerMock);
        $response = $client->get($requestMock);

        $this->assertSame($status, $response->getStatusCode());
        $eventList = $response->getEventList();
        $this->assertInstanceOf(EventContainerList::class, $eventList);
        $this->assertInstanceOf($eventClass, $eventList[0]->getEvent());
    }

    /**
     * @test
     */
    public function it_will_throw_UnexpectedValueException_when_eventList_is_missing(): void
    {
        $sut = new EventApi(
            self::createStub(AuthAwareApiClient::class),
            $serializer = self::createStub(JsonSerializer::class),
            self::createStub(ChannelApiResponseDeserializer::class),
        );

        $serializer->method('deserialize')->willReturn(['foo' => ['bar']]);
        self::expectException(\UnexpectedValueException::class);
        $sut->get();
    }

    /**
     * @test
     */
    public function it_add_ErroneousEvent_when_properties_are_missing(): void
    {
        $sut = new EventApi(
            $client = self::createStub(AuthAwareApiClient::class),
            $serializer = self::createStub(JsonSerializer::class),
            self::createStub(ChannelApiResponseDeserializer::class),
        );

        $response = self::createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $client->method('request')->willReturn($response);

        $serializer->method('deserialize')->willReturn(
            (object)[
                'eventList' => [
                    (object)[
                        'id' => "1",
                        'type' => 'foo',
                        'event' => new \stdClass(),
                        'createdAt' => '2021-01-07'
                    ],
                    (object)[
                        'id' => 2,
                        'type' => 'foo',
                        'event' => new \stdClass(),
                    ],
                    (object)[
                        'id' => 3,
                        'type' => 'foo',
                        'createdAt' => '2021-01-07'
                    ],
                    (object)[
                        'id' => 4,
                        'event' => new \stdClass(),
                        'createdAt' => '2021-01-07'
                    ],
                    (object)[
                        'type' => 'foo',
                        'event' => new \stdClass(),
                        'createdAt' => '2021-01-07'
                    ],
                ]
            ]
        );
        $response = $sut->get();
        self::assertCount(4, $response->getErroneousEvents());
        self::assertCount(1, $response->getEventList());
    }

    /**
     * @test
     */
    public function it_add_ErroneousEvent_when_deserialize_fail(): void
    {
        $sut = new EventApi(
            $client = self::createStub(AuthAwareApiClient::class),
            $serializer = self::createStub(JsonSerializer::class),
            $responseDeserializer = self::createStub(ChannelApiResponseDeserializer::class),
        );

        $response = self::createStub(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $client->method('request')->willReturn($response);

        $serializer->method('deserialize')->willReturn(
            (object)[
                'eventList' => [
                    (object)[
                        'id' => '1',
                        'type' => EventType::SellerOfferNew,
                        'event' => new \stdClass(),
                        'createdAt' => '2021-01-07'
                    ]
                ]
            ]
        );

        $e = new \Exception('boom');
        $responseDeserializer->method('deserializeObject')->willThrowException($e);
        $response = $sut->get();
        self::assertCount(1, $response->getErroneousEvents());
        self::assertCount(0, $response->getEventList());

        $err = $response->getErroneousEvents()[0];
        self::assertSame($e, $err->getException());
        self::assertSame('boom', $err->getErrorMessage());
    }


    public function testCanAck()
    {
        $request = new AcknowledgeEventIdListRequest(['1', '2']);

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(204);

        $apiClientMock = $this->createMock(AuthAwareApiClient::class);
        $apiClientMock->expects($this->once())->method('request')
            ->with($request)
            ->willReturn($responseMock);

        $jsonDeserializerMock = $this->createMock(JsonSerializer::class);
        $serializerMock = $this->createMock(ChannelApiResponseDeserializer::class);

        $client = new EventApi($apiClientMock, $jsonDeserializerMock, $serializerMock);

        $response = $client->ack($request);
        $this->assertInstanceOf(AcknowledgeEventIdListResponse::class, $response);
    }
}
