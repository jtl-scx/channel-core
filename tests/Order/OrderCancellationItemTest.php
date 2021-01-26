<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/9/20
 */

namespace Order;

use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\OrderCancellationItem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\OrderCancellationItem
 */
class OrderCancellationItemTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_a_orderItemId(): void
    {
        $sut = new OrderCancellationItem('A_ORDER_ITEM_ID', '1.0');
        $this->assertEquals('A_ORDER_ITEM_ID', $sut->getOrderItemId());
    }

    /**
     * @test
     */
    public function it_has_a_quantity(): void
    {
        $sut = new OrderCancellationItem('A_ORDER_ITEM_ID', '11.11');
        $this->assertEquals('11.11', $sut->getQuantity());
    }

    /**
     * @test
     */
    public function it_has_a_default_quantity(): void
    {
        $sut = new OrderCancellationItem('A_ORDER_ITEM_ID');
        $this->assertEquals('1.0', $sut->getQuantity());
    }
}
