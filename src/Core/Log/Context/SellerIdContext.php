<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;

class SellerIdContext
{
    private ChannelSellerId $channelSellerId;

    public function __construct(ChannelSellerId $channelSellerId)
    {
        $this->channelSellerId = $channelSellerId;
    }

    public function __invoke(array $record): array
    {
        $record['seller']['id'] = $this->channelSellerId->getId();
        return $record;
    }
}
