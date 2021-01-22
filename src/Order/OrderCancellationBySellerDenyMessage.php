<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\ChannelOrderIdRelatedMessage;
use JTL\SCX\Lib\Channel\Contract\Core\Message\SellerIdRelatedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class OrderCancellationBySellerDenyMessage extends OrderCancellationBySellerAcceptMessage
{
    private string $reason;

    public function __construct(
        ChannelSellerId $sellerId,
        string $orderCancellationRequestId,
        string $orderId,
        string $reason,
        array $failedOrderItemIdList,
        string $messageId = null
    ) {
        parent::__construct($sellerId, $orderCancellationRequestId, $orderId, $messageId);
        $this->reason = $reason;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

}