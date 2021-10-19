<?php

namespace JTL\SCX\Lib\Channel\Order\Refunds;

use JTL\SCX\Client\Channel\Model\ReturnAnnouncement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Order\Refunds\SendAnnouncedReturnMessage
 */
class SendAnnouncedReturnMessageTest extends TestCase
{
    private SendAnnouncedReturnMessage $sut;
    /**
     * @var ReturnAnnouncement&MockObject
     */
    private ReturnAnnouncement $returnAnnouncement;

    public function setUp(): void
    {
        $this->returnAnnouncement = $this->createMock(ReturnAnnouncement::class);
        $this->sut = new SendAnnouncedReturnMessage($this->returnAnnouncement);
    }

    public function testCanGetReturnAnnouncement(): void
    {
        self::assertSame($this->returnAnnouncement, $this->sut->getReturnAnnouncement());
    }

    public function testCanGetSellerId(): void
    {
        $sellerId = uniqid();
        $this->returnAnnouncement->expects(self::once())->method('getSellerId')->willReturn($sellerId);

        self::assertSame($sellerId, (string)$this->sut->getSellerId());
    }

    public function testCanGetChannelOrderId(): void
    {
        $orderId = uniqid();
        $this->returnAnnouncement->expects(self::once())->method('getOrderId')->willReturn($orderId);

        self::assertSame($orderId, $this->sut->getChannelOrderId());

    }
}
