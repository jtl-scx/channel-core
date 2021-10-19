<?php

namespace JTL\SCX\Lib\Channel\Order\Refunds;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\ReturnOrderRequest;
use JTL\SCX\Client\Channel\Model\ReturnAnnouncement;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Order\Refunds\SendAnnouncedReturnListener
 */
class SendAnnouncedReturnListenerTest extends TestCase
{
    public function testCanSendToChannelApi(): void
    {
        $returnAnnouncement = $this->createStub(ReturnAnnouncement::class);
        $returnAnnouncement->method('__toString')->willReturn(uniqid());
        $message = new SendAnnouncedReturnMessage($returnAnnouncement);

        $orderApi = $this->createMock(OrderApi::class);
        $orderApi->expects(self::once())->method('sendOrderReturn')->with(self::callback(
            function (ReturnOrderRequest $request) use ($returnAnnouncement) {
                self::assertSame((string)$returnAnnouncement, $request->getBody());
                return true;
            }
        ));
        $sut = new SendAnnouncedReturnListener($orderApi, $this->createStub(ScxLogger::class));

        $sut->sendToChannelApi($message);
    }
}
