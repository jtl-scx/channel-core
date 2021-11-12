<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\UpdateSeller;

class UpdateSellerRequest extends AbstractScxApiRequest
{
    private UpdateSeller $updateSeller;

    public function __construct(UpdateSeller $updateSeller)
    {
        $this->updateSeller = $updateSeller;
    }

    public function getUrl(): string
    {
        return '/v1/channel/seller';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PATCH;
    }

    public function getBody(): string
    {
        return (string)$this->updateSeller;
    }
}
