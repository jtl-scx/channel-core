<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/2/20
 */

namespace JTL\SCX\Lib\Channel\Order\Cancellation\Buyer;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\RequestOrderCancellationRequest;
use JTL\SCX\Client\Channel\Model\CancelReason;
use JTL\SCX\Client\Channel\Model\OrderCancellationItem as ScxOrderCancellationItem;
use JTL\SCX\Client\Channel\Model\OrderCancellationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Log\Context\ChannelOrderItemIdListContext;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class RequestCancellationListener extends AbstractListener
{
    private OrderApi $orderApi;

    public function __construct(OrderApi $orderApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->orderApi = $orderApi;
    }

    public function requestCancellation(RequestCancellationMessage $message): void
    {
        $orderItemList = $orderItemIdList = [];
        /** @var OrderCancellationItem $item */
        foreach ($message->getOrderCancellationItemList() as $item) {
            $orderItemIdList[] = $item->getOrderItemId();
            $orderItemList[] = new ScxOrderCancellationItem(
                ['orderItemId' => $item->getOrderItemId(), 'quantity' => $item->getQuantity()]
            );
        }
        $this->logger->replaceContext(new ChannelOrderItemIdListContext($orderItemIdList));

        $cancellationRequest = $this->buildOrderCancellationRequest($message, $orderItemList);
        $apiRequest = new RequestOrderCancellationRequest($cancellationRequest);

        $this->orderApi->requestOrderCancellation($apiRequest);

        $this->logger->info("Send CancelOrderRequest to SCX with OrderCancellationRequestId '{$message->getOrderCancellationRequestId()}'");
    }

    private function buildOrderCancellationRequest(
        RequestCancellationMessage $message,
        array $orderItemList
    ): OrderCancellationRequest {
        return new OrderCancellationRequest([
            'orderCancellationRequestId' => $message->getOrderCancellationRequestId(),
            'sellerId' => (string)$message->getSellerId(),
            'orderId' => $message->getChannelOrderId(),
            'orderItem' => $orderItemList,
            'cancelReason' => new CancelReason($message->getCancelReason()),
            'message' => $message->getMessage(),
        ]);
    }
}
