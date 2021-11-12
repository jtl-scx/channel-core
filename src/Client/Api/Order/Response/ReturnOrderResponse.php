<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 4/29/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class ReturnOrderResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
