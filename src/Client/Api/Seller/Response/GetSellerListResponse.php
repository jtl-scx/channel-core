<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use JTL\SCX\Client\Response\AbstractResponse;
use JTL\SCX\Lib\Channel\Client\Model\ChannelSellerList;

class GetSellerListResponse extends AbstractResponse
{
    public function __construct(
        private readonly ChannelSellerList $sellerList,
        int $statusCode,
    ) {
        parent::__construct($statusCode);
    }

    public function getSellerList(): ChannelSellerList
    {
        return $this->sellerList;
    }
}
