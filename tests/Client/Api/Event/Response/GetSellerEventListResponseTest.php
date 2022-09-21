<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Response;

use JTL\SCX\Lib\Channel\Client\Api\Event\Model\ErroneousEvent;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use PHPUnit\Framework\TestCase;

/**
 * Class GetSellerEventListResponseTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Event\Response
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\Response\GetSellerEventListResponse
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList
 */
class GetSellerEventListResponseTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $eventList = new EventContainerList();
        $statusCode = random_int(1, 1000);

        $response = new GetSellerEventListResponse($eventList, $statusCode);

        $this->assertSame($eventList, $response->getEventList());
        $this->assertSame($statusCode, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_may_have_a_list_of_ErroneousEvents(): void
    {
        $errorEvents = [$this->createStub(ErroneousEvent::class)];
        $sut = new GetSellerEventListResponse(
            $this->createStub(EventContainerList::class),
            200,
            $errorEvents
        );

        self::assertSame($errorEvents, $sut->getErroneousEvents());
    }
}
