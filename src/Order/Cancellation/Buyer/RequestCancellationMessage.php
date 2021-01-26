<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/2/20
 */

namespace JTL\SCX\Lib\Channel\Order\Cancellation\Buyer;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class RequestCancellationMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage
{
    private string $orderCancellationRequestId;
    private ChannelSellerId $sellerId;
    private string $orderId;
    private OrderCancellationItemList $orderCancellationItemList;
    private ?string $cancelReason;
    private ?string $message;

    public function __construct(
        string $orderCancellationRequestId,
        ChannelSellerId $sellerId,
        string $orderId,
        OrderCancellationItemList $orderCancellationItemList,
        ?string $cancelReason = null,
        ?string $message = null,
        ?string $messageId = null
    ) {
        parent::__construct($messageId);
        $this->orderCancellationRequestId = $orderCancellationRequestId;
        $this->sellerId = $sellerId;
        $this->orderId = $orderId;
        $this->orderCancellationItemList = $orderCancellationItemList;
        $this->cancelReason = $cancelReason;
        $this->message = $message;
    }

    public function getOrderCancellationRequestId(): string
    {
        return $this->orderCancellationRequestId;
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getOrderCancellationItemList(): OrderCancellationItemList
    {
        return $this->orderCancellationItemList;
    }

    public function getCancelReason(): ?string
    {
        return $this->cancelReason;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getChannelOrderId(): string
    {
        return $this->orderId;
    }
}
