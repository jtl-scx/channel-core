<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/12/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\CancellationDenied;

class DenyCancellationRequest extends AbstractScxApiRequest
{
    private CancellationDenied $denied;

    public function __construct(string $sellerId, string $orderCancellationRequestId, string $reason)
    {
        $this->denied = new CancellationDenied([
            'sellerId' => $sellerId,
            'orderCancellationRequestId' => $orderCancellationRequestId,
            'reason' => $reason
        ]);
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/cancellation-denied';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PUT;
    }

    public function getBody(): ?string
    {
        return (string)$this->denied;
    }
}
