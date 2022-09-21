<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/10/20
 */

namespace JTL\SCX\Lib\Channel\Client\Attribute;

use JTL\SCX\Lib\Channel\Client\Model\ChannelAttribute;

class AttributeSelector
{
    /**
     * @param string $attributeId
     * @param ChannelAttribute[] $channelAttributeList
     * @return array|null
     */
    public function getValueListById(string $attributeId, array $channelAttributeList): ?array
    {
        $results = [];
        /** @var ChannelAttribute $attribute */
        foreach ($channelAttributeList as $attribute) {
            if ($attribute->getAttributeId() === $attributeId) {
                $results[] = $attribute->getValue();
            }
        }
        return empty($results) ? null : $results;
    }

    /**
     * @param string $attributeId
     * @param array $channelAttributeList
     * @return string|null
     */
    public function getValueById(string $attributeId, array $channelAttributeList): ?string
    {
        /** @var ChannelAttribute $attribute */
        foreach ($channelAttributeList as $attribute) {
            if ($attribute->getAttributeId() === $attributeId) {
                return $attribute->getValue();
            }
        }
        return null;
    }
}
