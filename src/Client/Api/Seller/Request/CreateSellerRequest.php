<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/18
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\CreateSeller;
use JTL\SCX\Client\Request\ScxApiRequest;

class CreateSellerRequest extends AbstractScxApiRequest
{
    private CreateSeller $createSellerModel;

    public static function make(string $sellerId, string $session): CreateSellerRequest
    {
        return new self(new CreateSeller([
            'session' => $session,
            'sellerId' => $sellerId
        ]));
    }

    public function __construct(CreateSeller $createSellerModel)
    {
        $this->createSellerModel = $createSellerModel;
    }

    public function getCreateSellerModel(): CreateSeller
    {
        return $this->createSellerModel;
    }

    public function getUrl(): string
    {
        return '/v1/channel/seller';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }

    public function getBody(): string
    {
        return (string)$this->getCreateSellerModel();
    }
}
