<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;

/**
 * EA-7972: A channel implements this to provide the channel-wide shipping attributes it defines for
 * every seller (as opposed to the per-seller SellerShippingAttributeLoader). The list is pushed to
 * SCX together with the supported carriers via `PUT /v1/channel/shipping-rules` when the
 * `scx-api:put.shipping-rules` command runs.
 *
 * The channel-wide and the per-seller shipping attributes share the same `channelSpecificAttributeList`
 * on SCX but are enforced against two independent caps of 8 (channel-wide vs. per-seller).
 */
interface GlobalShippingAttributeLoader
{
    /**
     * @return ChannelSpecificShippingAttribute[] Max. 8 entries; an empty list pushes nothing.
     */
    public function load(): array;
}
