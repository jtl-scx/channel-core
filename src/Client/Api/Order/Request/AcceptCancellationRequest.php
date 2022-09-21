<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/12/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\CancellationAccept;

class AcceptCancellationRequest extends AbstractScxApiRequest
{
    private CancellationAccept $accept;

    public function __construct(string $sellerId, string $orderCancellationRequestId)
    {
        $this->accept = new CancellationAccept([
            'sellerId' => $sellerId,
            'orderCancellationRequestId' => $orderCancellationRequestId
        ]);
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/cancellation-accept';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PUT;
    }

    public function getBody(): ?string
    {
        return (string)$this->accept;
    }
}
