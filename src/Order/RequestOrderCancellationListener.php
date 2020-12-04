<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/2/20
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\CancelOrderRequest;
use JTL\SCX\Client\Channel\Model\OrderCancellationRequest2;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class RequestOrderCancellationListener extends AbstractListener
{
    private OrderApi $orderApi;

    public function __construct(OrderApi $orderApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->orderApi = $orderApi;
    }

    public function requestCancellation(RequestOrderCancellationMessage $message): void
    {
        $request = new OrderCancellationRequest2();
        $request->setOrderCancellationRequestId($message->getOrderCancellationRequestId());
        $request->setSellerId($message->getSellerId());
        $request->setOrderId($message->getOrderId());
        $request->setOrderItem($message->getOrderItem());
        $request->setCancelReason($message->getCancelReason());
        $request->setMessage($message->getMessage());
        $cancelOrderRequest = new CancelOrderRequest($request);
        $this->orderApi->cancel($cancelOrderRequest);
    }
}
