<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\ShippingRules;
use JTL\SCX\Client\Request\ScxApiRequest;

class CreateShippingRulesRequest extends AbstractScxApiRequest
{
    private ShippingRules $shippingRules;

    public function __construct(ShippingRules $shippingRules)
    {
        $this->shippingRules = $shippingRules;
    }

    public function getShippingRules(): ShippingRules
    {
        return $this->shippingRules;
    }

    public function getUrl(): string
    {
        return '/v1/channel/shipping-rules';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_PUT;
    }

    public function getBody(): string
    {
        return (string)$this->getShippingRules();
    }
}
