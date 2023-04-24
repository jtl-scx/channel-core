<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/9/20
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\RequestOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\OrderCancellationItem;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\OrderCancellationItemList;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\RequestCancellationListener;
use JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\RequestCancellationMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Buyer\RequestCancellationListener
 */
class RequestCancellationListenerTest extends TestCase
{
    /**
     * @test
     */
    public function it_send_a_orderCancellationRequest_to_Channel_API(): void
    {
        $apiMock = $this->createMock(OrderApi::class);
        $loggerStub = $this->createStub(ScxLogger::class);

        $sut = new RequestCancellationListener($apiMock, $loggerStub);

        $message = $this->createMock(RequestCancellationMessage::class);
        $message->method('getOrderCancellationRequestId')->willReturn('A_ID');
        $message->method('getSellerId')->willReturn(new ChannelSellerId('A_SELLER_ID'));
        $message->method('getChannelOrderId')->willReturn('A_ORDER_ID');
        $message->method('getCancelReason')->willReturn('OTHER');
        $message->method('getMessage')->willReturn('A_MESSAGE');
        $message->method('getOrderCancellationItemList')->willReturn(
            OrderCancellationItemList::from(
                new OrderCancellationItem('1'),
                new OrderCancellationItem('2', '2.0')
            )
        );

        $apiMock->expects($this->once())
            ->method('requestOrderCancellation')
            ->with($this->callback(function (RequestOrderCancellationRequest $apiRequest) {
                $request = json_decode($apiRequest->getBody(), true);
                $this->assertArrayHasKey('orderCancellationRequestId', $request);
                $this->assertArrayHasKey('sellerId', $request);
                $this->assertArrayHasKey('orderId', $request);
                $this->assertArrayHasKey('cancelReason', $request);
                $this->assertArrayHasKey('message', $request);
                $this->assertArrayHasKey('orderItem', $request);

                $this->assertEquals('A_ID', $request['orderCancellationRequestId']);
                $this->assertEquals('A_SELLER_ID', $request['sellerId']);
                $this->assertEquals('A_ORDER_ID', $request['orderId']);
                $this->assertEquals('OTHER', $request['cancelReason']);
                $this->assertEquals('A_MESSAGE', $request['message']);

                $this->assertCount(2, $request['orderItem']);
                $this->assertEquals('1', $request['orderItem'][0]['orderItemId']);
                $this->assertEquals('1.0', $request['orderItem'][0]['quantity']);
                $this->assertEquals('2', $request['orderItem'][1]['orderItemId']);
                $this->assertEquals('2.0', $request['orderItem'][1]['quantity']);
                return true;
            }));
        $sut->requestCancellation($message);
    }
}
