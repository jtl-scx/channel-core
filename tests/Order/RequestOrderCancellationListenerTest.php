<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/9/20
 */

namespace Order;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\RequestOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Order\OrderCancellationItem;
use JTL\SCX\Lib\Channel\Order\OrderCancellationItemList;
use JTL\SCX\Lib\Channel\Order\RequestOrderCancellationListener;
use JTL\SCX\Lib\Channel\Order\RequestOrderCancellationMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\RequestOrderCancellationListener
 */
class RequestOrderCancellationListenerTest extends TestCase
{

    /**
     * @test
     */
    public function it_send_a_orderCancellationRequest_to_Channel_API(): void
    {
        $apiMock = $this->createMock(OrderApi::class);
        $loggerStub = $this->createStub(ScxLogger::class);

        $sut = new RequestOrderCancellationListener($apiMock, $loggerStub);

        $message = $this->createMock(RequestOrderCancellationMessage::class);
        $message->method('getOrderCancellationRequestId')->willReturn('A_ID');
        $message->method('getSellerId')->willReturn(new ChannelSellerId('A_SELLER_ID'));
        $message->method('getChannelOrderId')->willReturn('A_ORDER_ID');
        $message->method('getCancelReason')->willReturn('A_REASON');
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
                $request = json_decode($apiRequest->getBody());
                $this->assertCorrectProperty($request, 'orderCancellationRequestId', 'A_ID');
                $this->assertCorrectProperty($request, 'sellerId', 'A_SELLER_ID');
                $this->assertCorrectProperty($request, 'orderId', 'A_ORDER_ID');
                $this->assertCorrectProperty($request, 'cancelReason', 'A_REASON');
                $this->assertCorrectProperty($request, 'message', 'A_MESSAGE');
                $this->assertCorrectProperty($request, 'orderItem', [
                    (object)['orderItemId' => '1', 'quantity' => "1.0"],
                    (object)['orderItemId' => '2', 'quantity' => "2.0"]
                ]);
                return true;
            }));
        ;
        $sut->requestCancellation($message);
    }

    public function assertCorrectProperty(\stdClass $given, string $property, $value)
    {
        $this->assertObjectHasAttribute($property, $given);
        $this->assertEquals(
            $value,
            $given->$property,
            "Expect that {$property} is value " . var_export($value, true)
            . "; given " . var_export($given->$property, true)
        );
    }
}
