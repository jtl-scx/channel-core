<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\GlobalShippingAttributeLoader;

/**
 * Default no-op loader. It is bound in core-service.yaml — unlike DefaultGlobalAttributeLoader, which is
 * an unbound throwing stub — because the GlobalShippingAttributeLoader is consumed by the shared
 * `scx-api:put.shipping-rules` command. That command also pushes the supported carriers, so it must keep
 * working for channels that manage carriers but no channel-wide shipping attributes: they push nothing here.
 * Channels that need channel-wide shipping attributes bind the contract to their own implementation.
 */
class DefaultGlobalShippingAttributeLoader implements GlobalShippingAttributeLoader
{
    public function load(): array
    {
        return [];
    }
}
