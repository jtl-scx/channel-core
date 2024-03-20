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

/**
 * Class AttributeSelector
 *
 * This class provides methods to select and retrieve attribute values from a given list of channel attributes.
 */
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
        foreach ($channelAttributeList as $attribute) {
            if ($attribute->getAttributeId() === $attributeId) {
                $results[] = $attribute->getValue();
            }
        }
        return empty($results) ? null : $results;
    }

    /**
     * @param string $attributeId
     * @param ChannelAttribute[] $channelAttributeList
     * @return string|null
     */
    public function getValueById(string $attributeId, array $channelAttributeList): ?string
    {
        foreach ($channelAttributeList as $attribute) {
            if ($attribute->getAttributeId() === $attributeId) {
                return $attribute->getValue();
            }
        }
        return null;
    }


    /**
     * Retrieves a boolean value by attribute name from a list of channel attributes.
     *
     * @param string $attributeId The attribute name to search for.
     * @param ChannelAttribute[] $channelAttributeList The list of channel attributes.
     * @param bool|null $default (optional) The default value to return if the attribute is not found. Defaults to null.
     * @return bool|null The boolean value corresponding to the attribute name, or the default value if not found.
     */
    public function getBooleanById(string $attributeId, array $channelAttributeList, bool|null $default = null): bool|null
    {
        $value = $this->getValueById($attributeId, $channelAttributeList);
        if ($value === null) {
            return $default;
        }

        return match(strtolower($value)) {
            'true', '1', 'yes', 'y', 'ja', 'j', 'on', 'w', 'wahr' => true,
            default => false,
        };
    }
}
