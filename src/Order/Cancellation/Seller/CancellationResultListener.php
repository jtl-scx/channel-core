<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Order\Cancellation\Seller;

use JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\AcceptCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\DenyCancellationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class CancellationResultListener extends AbstractListener
{
    private OrderApi $orderApi;

    public function __construct(OrderApi $orderApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->orderApi = $orderApi;
    }

    public function handleAccept(CancellationAcceptMessage $message): void
    {
        $request = new AcceptCancellationRequest(
            (string)$message->getSellerId(),
            $message->getCancellationRequestId()
        );
        $this->orderApi->acceptOrderCancellation($request);

        $this->logger->info("Order cancellation accepted was send back to Channel-API");
    }

    public function handleDeny(CancellationDenyMessage $message): void
    {
        $request = new DenyCancellationRequest(
            (string)$message->getSellerId(),
            $message->getCancellationRequestId(),
            $message->getReason()
        );
        $this->orderApi->denyOrderCancellation($request);

        $this->logger->info("Order cancellation denied was send back to Channel-API. Reason: {$message->getReason()}");
    }
}
