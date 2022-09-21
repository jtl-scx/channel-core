<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class ConditionalAttribute
{
    /**
     * @var string
     */
    private $attributeId;

    /**
     * @var array
     */
    private $attributeValues;

    /**
     * ConditionalAttribute constructor.
     * @param string $attributeId
     * @param array $attributeValues
     */
    public function __construct(string $attributeId, array $attributeValues)
    {
        $this->attributeId = $attributeId;
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return string
     */
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    /**
     * @return array
     */
    public function getAttributeValues(): array
    {
        return $this->attributeValues;
    }
}
