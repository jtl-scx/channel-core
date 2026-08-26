<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;

/**
 * EA-8054: A channel implements this to provide the seller specific shipping attributes
 * (e.g. a return-warehouse selection) that are pushed to SCX via
 * `PUT /v1/channel/shipping-rules/{sellerId}`.
 */
interface SellerShippingAttributeLoader
{
    /**
     * @return ChannelSpecificShippingAttribute[] Max. 8 entries; an empty list pushes nothing.
     */
    public function fetchAll(string $sellerId): array;
}
