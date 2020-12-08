<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/2/20
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Client\Channel\Model\OrderCancellationItem;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class RequestOrderCancellationMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage
{
    private string $orderCancellationRequestId;
    private ChannelSellerId $sellerId;
    private string $orderId;

    /**
     * @var OrderCancellationItem[]
     */
    private array $orderItem;
    private ?string $cancelReason;
    private ?string $message;

    public function __construct(
        string $orderCancellationRequestId,
        ChannelSellerId $sellerId,
        string $orderId,
        array $orderItem,
        ?string $cancelReason = null,
        ?string $message = null,
        ?string $messageId = null
    ) {
        parent::__construct($messageId);
        $this->orderCancellationRequestId = $orderCancellationRequestId;
        $this->sellerId = $sellerId;
        $this->orderId = $orderId;
        $this->orderItem = $orderItem;
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

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getOrderItem(): array
    {
        return $this->orderItem;
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
        return $this->getOrderId();
    }
}
