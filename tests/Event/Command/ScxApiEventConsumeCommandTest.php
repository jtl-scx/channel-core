<?php

namespace JTL\SCX\Lib\Channel\Event\Command;

use JTL\SCX\Lib\Channel\Client\Api\Event\EventApi;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\ErroneousEvent;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Response\GetSellerEventListResponse;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Command\ScxApiEventConsumeCommand
 */
class ScxApiEventConsumeCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_emit_seller_event_to_message_queue(): void
    {
        $sut = new ScxApiEventConsumeCommand(
            $api = $this->createMock(EventApi::class),
            $emitter = $this->createMock(SellerEventEmitter::class),
            $this->createStub(ScxLogger::class)
        );

        $testEvents = $this->createStub(EventContainerList::class);
        $testEvents->method('count')->willReturn(2);

        $api->method('get')->willReturnOnConsecutiveCalls(
            $this->buildEventApiResponse($testEvents),
            $this->buildEmptyEventApiResponse()
        );

        $eventIdForAck = ['1', '2'];
        $emitter->expects(self::once())
            ->method('emit')
            ->with($testEvents)
            ->willReturn($eventIdForAck);

        $api->method('ack');

        $tester = new CommandTester($sut);
        $tester->execute([]);
    }

    /**
     * @test
     */
    public function it_will_read_event_from_api_until_there_are_no_new_event_available(): void
    {
        $sut = new ScxApiEventConsumeCommand(
            $api = $this->createMock(EventApi::class),
            $this->createStub(SellerEventEmitter::class),
            $this->createStub(ScxLogger::class)
        );

        $api->expects(self::exactly(3))->method('get')->willReturnOnConsecutiveCalls(
            $this->buildEventApiResponse(),
            $this->buildEventApiResponse(),
            $this->buildEmptyEventApiResponse()
        );

        $tester = new CommandTester($sut);
        $tester->execute([]);
    }

    /**
     * @test
     */
    public function it_will_acknowledge_each_successful_emitted_event(): void
    {
        $sut = new ScxApiEventConsumeCommand(
            $api = $this->createMock(EventApi::class),
            $emitter = $this->createStub(SellerEventEmitter::class),
            $this->createStub(ScxLogger::class)
        );

        $api->method('get')->willReturnOnConsecutiveCalls(
            $this->buildEventApiResponse(),
            $this->buildEmptyEventApiResponse()
        );

        $eventIdForAck = ['1', '2'];
        $emitter->method('emit')->willReturn($eventIdForAck);
        $api->expects(self::once())->method('ack')->with(self::callback(
            function (AcknowledgeEventIdListRequest $request) use ($eventIdForAck) {
                self::assertEquals($eventIdForAck, $request->getEventIdListModel()->getEventIdList());
                return true;
            }
        ));

        $tester = new CommandTester($sut);
        $tester->execute([]);
    }

    /**
     * @test
     */
    public function it_will_log_erroneous_events(): void
    {
        $sut = new ScxApiEventConsumeCommand(
            $api = $this->createMock(EventApi::class),
            $this->createStub(SellerEventEmitter::class),
            $logger = $this->createMock(ScxLogger::class)
        );

        $testEvents = $this->createStub(EventContainerList::class);
        $testEvents->method('count')->willReturn(2);

        $response = $this->createStub(GetSellerEventListResponse::class);
        $response->method('getEventList')->willReturn($testEvents);

        $withError = [
            $this->createStub(ErroneousEvent::class),
            $this->createStub(ErroneousEvent::class),
        ];
        $response->method('getErroneousEvents')->willReturn($withError);

        $api->method('get')->willReturnOnConsecutiveCalls(
            $response,
            $this->buildEmptyEventApiResponse()
        );

        $logger->expects(self::exactly(2))
            ->method("warning")
            ->with(self::stringStartsWith("Erroneous Event ignored"));

        $tester = new CommandTester($sut);
        $tester->execute([]);
    }


    protected function buildEmptyEventApiResponse(): GetSellerEventListResponse
    {
        $testEvents = $this->createStub(EventContainerList::class);
        $testEvents->method('count')->willReturn(0);

        $response = $this->createStub(GetSellerEventListResponse::class);
        $response->method('getEventList')->willReturn($testEvents);
        return $response;
    }

    /**
     * @param $testEvents
     * @return \JTL\SCX\Lib\Channel\Client\Api\Event\Response\GetSellerEventListResponse|\PHPUnit\Framework\MockObject\Stub
     */
    protected function buildEventApiResponse($testEvents = null)
    {
        if ($testEvents === null) {
            $testEvents = $this->createStub(EventContainerList::class);
            $testEvents->method('count')->willReturn(2);
        }

        $response = $this->createStub(GetSellerEventListResponse::class);
        $response->method('getEventList')->willReturn($testEvents);
        return $response;
    }
}
