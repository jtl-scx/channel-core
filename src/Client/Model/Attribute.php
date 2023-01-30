<?php
/**
 * Attribute
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace JTL\SCX\Lib\Channel\Client\Model;

use ArrayAccess;
use JTL\SCX\Lib\Channel\Client\ObjectSerializer;

/**
 * Attribute Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class Attribute implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Attribute';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param AllowedValue
      * @param AttributeConditionalMandatoryBy
      * @param AttributeConditionalOptionalBy
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'attributeId' => 'string',
        'displayName' => 'string',
        'isMultipleAllowed' => 'bool',
        'type' => 'string',
        'values' => '\JTL\SCX\Lib\Channel\Client\Model\AllowedValue[]',
        'attributeValueValidation' => 'string',
        'conditionalMandatoryBy' => '\JTL\SCX\Lib\Channel\Client\Model\AttributeConditionalMandatoryBy[]',
        'conditionalOptionalBy' => '\JTL\SCX\Lib\Channel\Client\Model\AttributeConditionalOptionalBy[]',
        'required' => 'bool',
        'recommended' => 'bool',
        'section' => 'string',
        'sectionPosition' => 'int',
        'isRepeatableSubSection' => 'bool',
        'subSection' => 'string',
        'subSectionPosition' => 'int',
        'description' => 'string',
        'isVariationDimension' => 'bool',
        'enumValues' => 'string[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'attributeId' => null,
        'displayName' => null,
        'isMultipleAllowed' => null,
        'type' => null,
        'values' => null,
        'attributeValueValidation' => null,
        'conditionalMandatoryBy' => null,
        'conditionalOptionalBy' => null,
        'required' => null,
        'recommended' => null,
        'section' => null,
        'sectionPosition' => null,
        'isRepeatableSubSection' => null,
        'subSection' => null,
        'subSectionPosition' => null,
        'description' => null,
        'isVariationDimension' => null,
        'enumValues' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     * @codeCoverageIgnore
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     * @codeCoverageIgnore
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'attributeId' => 'attributeId',
        'displayName' => 'displayName',
        'isMultipleAllowed' => 'isMultipleAllowed',
        'type' => 'type',
        'values' => 'values',
        'attributeValueValidation' => 'attributeValueValidation',
        'conditionalMandatoryBy' => 'conditionalMandatoryBy',
        'conditionalOptionalBy' => 'conditionalOptionalBy',
        'required' => 'required',
        'recommended' => 'recommended',
        'section' => 'section',
        'sectionPosition' => 'sectionPosition',
        'isRepeatableSubSection' => 'isRepeatableSubSection',
        'subSection' => 'subSection',
        'subSectionPosition' => 'subSectionPosition',
        'description' => 'description',
        'isVariationDimension' => 'isVariationDimension',
        'enumValues' => 'enumValues'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'attributeId' => 'setAttributeId',
        'displayName' => 'setDisplayName',
        'isMultipleAllowed' => 'setIsMultipleAllowed',
        'type' => 'setType',
        'values' => 'setValues',
        'attributeValueValidation' => 'setAttributeValueValidation',
        'conditionalMandatoryBy' => 'setConditionalMandatoryBy',
        'conditionalOptionalBy' => 'setConditionalOptionalBy',
        'required' => 'setRequired',
        'recommended' => 'setRecommended',
        'section' => 'setSection',
        'sectionPosition' => 'setSectionPosition',
        'isRepeatableSubSection' => 'setIsRepeatableSubSection',
        'subSection' => 'setSubSection',
        'subSectionPosition' => 'setSubSectionPosition',
        'description' => 'setDescription',
        'isVariationDimension' => 'setIsVariationDimension',
        'enumValues' => 'setEnumValues'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'attributeId' => 'getAttributeId',
        'displayName' => 'getDisplayName',
        'isMultipleAllowed' => 'getIsMultipleAllowed',
        'type' => 'getType',
        'values' => 'getValues',
        'attributeValueValidation' => 'getAttributeValueValidation',
        'conditionalMandatoryBy' => 'getConditionalMandatoryBy',
        'conditionalOptionalBy' => 'getConditionalOptionalBy',
        'required' => 'getRequired',
        'recommended' => 'getRecommended',
        'section' => 'getSection',
        'sectionPosition' => 'getSectionPosition',
        'isRepeatableSubSection' => 'getIsRepeatableSubSection',
        'subSection' => 'getSubSection',
        'subSectionPosition' => 'getSubSectionPosition',
        'description' => 'getDescription',
        'isVariationDimension' => 'getIsVariationDimension',
        'enumValues' => 'getEnumValues'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     * @codeCoverageIgnore
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @codeCoverageIgnore
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @codeCoverageIgnore
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     * @codeCoverageIgnore
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    const TYPE_SMALLTEXT = 'smalltext';
    const TYPE_HTMLTEXT = 'htmltext';
    const TYPE_TEXT = 'text';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_ENUM = 'enum';
    const TYPE_DATE = 'date';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_IMAGE = 'image';
    const TYPE_DOCUMENT = 'document';
    const TYPE_URL = 'url';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_SMALLTEXT,
            self::TYPE_HTMLTEXT,
            self::TYPE_TEXT,
            self::TYPE_INTEGER,
            self::TYPE_DECIMAL,
            self::TYPE_ENUM,
            self::TYPE_DATE,
            self::TYPE_BOOLEAN,
            self::TYPE_IMAGE,
            self::TYPE_DOCUMENT,
            self::TYPE_URL,
        ];
    }
    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    public function __construct(array $data = null)
    {
        $this->container['attributeId'] = $data['attributeId'] ?? null;
        $this->container['displayName'] = $data['displayName'] ?? null;
        $this->container['isMultipleAllowed'] = $data['isMultipleAllowed'] ?? false;
        $this->container['type'] = $data['type'] ?? 'smalltext';
        $this->container['values'] = $data['values'] ?? null;
        $this->container['attributeValueValidation'] = $data['attributeValueValidation'] ?? null;
        $this->container['conditionalMandatoryBy'] = $data['conditionalMandatoryBy'] ?? null;
        $this->container['conditionalOptionalBy'] = $data['conditionalOptionalBy'] ?? null;
        $this->container['required'] = $data['required'] ?? false;
        $this->container['recommended'] = $data['recommended'] ?? false;
        $this->container['section'] = $data['section'] ?? null;
        $this->container['sectionPosition'] = $data['sectionPosition'] ?? 0;
        $this->container['isRepeatableSubSection'] = $data['isRepeatableSubSection'] ?? false;
        $this->container['subSection'] = $data['subSection'] ?? null;
        $this->container['subSectionPosition'] = $data['subSectionPosition'] ?? 0;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['isVariationDimension'] = $data['isVariationDimension'] ?? null;
        $this->container['enumValues'] = $data['enumValues'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['attributeId'] === null) {
            $invalidProperties[] = "'attributeId' can't be null";
        }
        if ((mb_strlen($this->container['attributeId']) > 512)) {
            $invalidProperties[] = "invalid value for 'attributeId', the character length must be smaller than or equal to 512.";
        }

        if ((mb_strlen($this->container['attributeId']) < 1)) {
            $invalidProperties[] = "invalid value for 'attributeId', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['displayName'] === null) {
            $invalidProperties[] = "'displayName' can't be null";
        }
        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($this->container['type']) && !in_array($this->container['type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'type', must be one of '%s'",
                $this->container['type'],
                implode("', '", $allowedValues)
            );
        }

        if (!is_null($this->container['attributeValueValidation']) && (mb_strlen($this->container['attributeValueValidation']) > 1024)) {
            $invalidProperties[] = "invalid value for 'attributeValueValidation', the character length must be smaller than or equal to 1024.";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     * @codeCoverageIgnore
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    public function getAttributeId(): string
    {
        return $this->container['attributeId'];
    }

    public function setAttributeId(string $attributeId): Attribute
    {
        $this->container['attributeId'] = $attributeId;
        return $this;
    }


    public function getDisplayName(): string
    {
        return $this->container['displayName'];
    }

    public function setDisplayName(string $displayName): Attribute
    {
        $this->container['displayName'] = $displayName;
        return $this;
    }


    public function getIsMultipleAllowed(): ?bool
    {
        return $this->container['isMultipleAllowed'];
    }

    public function setIsMultipleAllowed(?bool $isMultipleAllowed): Attribute
    {
        $this->container['isMultipleAllowed'] = $isMultipleAllowed;
        return $this;
    }


    public function getType(): ?string
    {
        return $this->container['type'];
    }

    public function setType(?string $type): Attribute
    {
        $this->container['type'] = $type;
        return $this;
    }


    public function getValues(): ?array
    {
        return $this->container['values'];
    }

    public function setValues(?array $values): Attribute
    {
        $this->container['values'] = $values;
        return $this;
    }


    public function getAttributeValueValidation(): ?string
    {
        return $this->container['attributeValueValidation'];
    }

    public function setAttributeValueValidation(?string $attributeValueValidation): Attribute
    {
        $this->container['attributeValueValidation'] = $attributeValueValidation;
        return $this;
    }


    public function getConditionalMandatoryBy(): ?array
    {
        return $this->container['conditionalMandatoryBy'];
    }

    public function setConditionalMandatoryBy(?array $conditionalMandatoryBy): Attribute
    {
        $this->container['conditionalMandatoryBy'] = $conditionalMandatoryBy;
        return $this;
    }


    public function getConditionalOptionalBy(): ?array
    {
        return $this->container['conditionalOptionalBy'];
    }

    public function setConditionalOptionalBy(?array $conditionalOptionalBy): Attribute
    {
        $this->container['conditionalOptionalBy'] = $conditionalOptionalBy;
        return $this;
    }


    public function getRequired(): ?bool
    {
        return $this->container['required'];
    }

    public function setRequired(?bool $required): Attribute
    {
        $this->container['required'] = $required;
        return $this;
    }


    public function getRecommended(): ?bool
    {
        return $this->container['recommended'];
    }

    public function setRecommended(?bool $recommended): Attribute
    {
        $this->container['recommended'] = $recommended;
        return $this;
    }


    public function getSection(): ?string
    {
        return $this->container['section'];
    }

    public function setSection(?string $section): Attribute
    {
        $this->container['section'] = $section;
        return $this;
    }


    public function getSectionPosition(): ?int
    {
        return $this->container['sectionPosition'];
    }

    public function setSectionPosition(?int $sectionPosition): Attribute
    {
        $this->container['sectionPosition'] = $sectionPosition;
        return $this;
    }


    public function getIsRepeatableSubSection(): ?bool
    {
        return $this->container['isRepeatableSubSection'];
    }

    public function setIsRepeatableSubSection(?bool $isRepeatableSubSection): Attribute
    {
        $this->container['isRepeatableSubSection'] = $isRepeatableSubSection;
        return $this;
    }


    public function getSubSection(): ?string
    {
        return $this->container['subSection'];
    }

    public function setSubSection(?string $subSection): Attribute
    {
        $this->container['subSection'] = $subSection;
        return $this;
    }


    public function getSubSectionPosition(): ?int
    {
        return $this->container['subSectionPosition'];
    }

    public function setSubSectionPosition(?int $subSectionPosition): Attribute
    {
        $this->container['subSectionPosition'] = $subSectionPosition;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->container['description'];
    }

    public function setDescription(?string $description): Attribute
    {
        $this->container['description'] = $description;
        return $this;
    }


    public function getIsVariationDimension(): ?bool
    {
        return $this->container['isVariationDimension'];
    }

    public function setIsVariationDimension(?bool $isVariationDimension): Attribute
    {
        $this->container['isVariationDimension'] = $isVariationDimension;
        return $this;
    }


    public function getEnumValues(): ?array
    {
        return $this->container['enumValues'];
    }

    public function setEnumValues(?array $enumValues): Attribute
    {
        $this->container['enumValues'] = $enumValues;
        return $this;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     * @codeCoverageIgnore
     * @return void
     */
    public function offsetSet($offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     * @codeCoverageIgnore
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     * @codeCoverageIgnore
     */
    public function jsonSerialize(): mixed
    {
        return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     * @codeCoverageIgnore
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            $this->jsonSerialize(),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     * @codeCoverageIgnore
     * @return string
     */
    public function toHeaderValue(): string
    {
        return json_encode($this->jsonSerialize());
    }
}


