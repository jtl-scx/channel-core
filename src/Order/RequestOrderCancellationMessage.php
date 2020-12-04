<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/2/20
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Client\Channel\Model\OrderItem1;

class RequestOrderCancellationMessage extends AbstractAmqpTransportableMessage
{
    private string $orderCancellationRequestId;
    private string $sellerId;
    private string $orderId;

    /**
     * @var OrderItem1[]
     */
    private array $orderItem;
    private ?string $cancelReason;
    private ?string $message;

    public function __construct(
        string $orderCancellationRequestId,
        string $sellerId,
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

    public function getSellerId(): string
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
}
