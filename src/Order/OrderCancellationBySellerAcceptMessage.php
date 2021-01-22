<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\CancellationRequestIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class OrderCancellationBySellerAcceptMessage extends AbstractAmqpTransportableMessage implements SellerIdRelatedMessage, ChannelOrderIdRelatedMessage, CancellationRequestIdRelatedMessage
{
    private ChannelSellerId $sellerId;
    private string $orderCancellationRequestId;
    private string $orderId;


    public function __construct(
        ChannelSellerId $sellerId,
        string $orderCancellationRequestId,
        string $orderId,
        string $messageId = null
    ) {
        parent::__construct($messageId);
        $this->sellerId = $sellerId;
        $this->orderCancellationRequestId = $orderCancellationRequestId;
        $this->orderId = $orderId;
    }


    public function getChannelOrderId(): string
    {
        return $this->orderId;
    }

    public function getSellerId(): ChannelSellerId
    {
        return $this->sellerId;
    }

    public function getCancellationRequestId(): string
    {
        return $this->orderCancellationRequestId;
    }

}