<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace Order;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\AcceptCancellationRequest;
use JTL\SCX\Client\Channel\Api\Order\Request\DenyCancellationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationAcceptMessage;
use JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationDenyMessage;
use JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationResultListener;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Order\Cancellation\Seller\CancellationResultListener
 */
class CancellationResultListenerTest extends TestCase
{
    public function testHandleDeny()
    {
        $sellerIdStr = uniqid();
        $sellerId = new ChannelSellerId($sellerIdStr);
        $requestId = uniqid('requestId', true);
        $reason = uniqid('reason', true);
        $message = new CancellationDenyMessage($sellerId, $requestId, uniqid('orderId', true), $reason);

        $orderApi = $this->createMock(OrderApi::class);
        $orderApi->expects(self::once())->method('denyOrderCancellation')->with(
            self::callback(
                function (DenyCancellationRequest $request) use ($sellerIdStr, $requestId, $reason) {
                    $dataJson = json_encode(
                        [
                            "sellerId" => $sellerIdStr,
                            "orderCancellationRequestId" => $requestId,
                            "reason" => $reason
                        ],
                        JSON_PRETTY_PRINT
                    );
                    return $dataJson === $request->getBody();
                }
            )
        );
        $listener = new CancellationResultListener($orderApi, $this->createStub(ScxLogger::class));
        $listener->handleDeny($message);
    }

    public function testHandleAccept()
    {
        $sellerIdStr = uniqid();
        $sellerId = new ChannelSellerId($sellerIdStr);
        $requestId = uniqid('requestId', true);
        $message = new CancellationAcceptMessage($sellerId, $requestId, uniqid('orderId', true));

        $orderApi = $this->createMock(OrderApi::class);
        $orderApi->expects(self::once())->method('acceptOrderCancellation')->with(
            self::callback(
                function (AcceptCancellationRequest $request) use ($sellerIdStr, $requestId) {
                    $dataJson = json_encode(
                        [
                            "sellerId" => $sellerIdStr,
                            "orderCancellationRequestId" => $requestId,
                        ],
                        JSON_PRETTY_PRINT
                    );
                    return $dataJson === $request->getBody();
                }
            )
        );
        $listener = new CancellationResultListener($orderApi, $this->createStub(ScxLogger::class));
        $listener->handleAccept($message);
    }
}
