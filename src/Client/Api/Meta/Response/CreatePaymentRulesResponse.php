<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class CreatePaymentRulesResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
