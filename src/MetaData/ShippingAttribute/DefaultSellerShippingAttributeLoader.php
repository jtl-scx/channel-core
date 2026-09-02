<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\SellerShippingAttributeLoader;

/**
 * Default no-op loader. Channels that do not provide seller specific shipping attributes keep this
 * implementation and therefore push nothing. Channels that need the feature bind the
 * SellerShippingAttributeLoader contract to their own implementation via service.yaml.
 */
class DefaultSellerShippingAttributeLoader implements SellerShippingAttributeLoader
{
    public function fetchAll(string $sellerId): array
    {
        return [];
    }
}
