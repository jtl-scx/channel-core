<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Meta\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\PaymentRules;
use JTL\SCX\Lib\Channel\Client\Model\ShippingRules;
use JTL\SCX\Client\Request\ScxApiRequest;

class CreatePaymentRulesRequest extends AbstractScxApiRequest
{
    private PaymentRules $paymentRules;

    public function __construct(PaymentRules $paymentRules)
    {
        $this->paymentRules = $paymentRules;
    }

    public function getPaymentRules(): PaymentRules
    {
        return $this->paymentRules;
    }


    public function getUrl(): string
    {
        return '/v1/channel/payment-rules';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_PUT;
    }

    public function getBody(): string
    {
        return (string)$this->getPaymentRules();
    }
}
