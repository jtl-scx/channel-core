<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/24
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventOrderRefund;
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
        $createdAt = new \DateTimeImmutable();
        $event = $this->createMock(SellerEventOrderRefund::class);

        $orderRefundEvent = new OrderRefundEvent(
            $id,
            $createdAt,
            $event
        );

        $this->assertEquals($id, $orderRefundEvent->getId());
        $this->assertEquals($createdAt, $orderRefundEvent->getCreatedAt());
        $this->assertEquals($event, $orderRefundEvent->getEvent());
    }
}
