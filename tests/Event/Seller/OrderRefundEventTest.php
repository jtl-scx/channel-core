<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/24
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderRefund;
use PHPUnit\Framework\TestCase;

/**
 * Class OrderRefundEventTest
 * @package JTL\SCX\Lib\Channel\Event\Seller
 *
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\OrderRefundEvent
 */
class OrderRefundEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_created()
    {
        $id = uniqid('id', true);
        $version = uniqid('version', true);
        $createdAt = new \DateTimeImmutable();
        $sellerId = uniqid('sellerId', true);
        $refundId = uniqid('refundId', true);
        $orderId = uniqid('orderId', true);
        $event = $this->createMock(SellerEventOrderRefund::class);
        $event->expects(self::once())->method('getSellerId')->willReturn($sellerId);
        $event->expects(self::once())->method('getRefundId')->willReturn($refundId);
        $event->expects(self::once())->method('getOrderId')->willReturn($orderId);

        $orderRefundEvent = new OrderRefundEvent(
            $id,
            $version,
            $createdAt,
            $event
        );

        self::assertEquals($id, $orderRefundEvent->getId());
        self::assertEquals($createdAt, $orderRefundEvent->getCreatedAt());
        self::assertEquals($event, $orderRefundEvent->getEvent());
        self::assertEquals($sellerId, (string)$orderRefundEvent->getSellerId());
        self::assertEquals($refundId, $orderRefundEvent->getRefundId());
        self::assertEquals($orderId, $orderRefundEvent->getChannelOrderId());
    }
}
