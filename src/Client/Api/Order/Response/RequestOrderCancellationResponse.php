<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 12/1/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

class RequestOrderCancellationResponse extends AbstractOrderResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
