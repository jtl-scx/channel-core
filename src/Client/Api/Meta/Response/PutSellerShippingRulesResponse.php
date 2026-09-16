<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class PutSellerShippingRulesResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
