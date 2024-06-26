<?php
/**
 * OfferListingFailedError
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
 * OfferListingFailedError Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class OfferListingFailedError implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'OfferListingFailedError';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'code' => 'string',
        'message' => 'string',
        'longMessage' => 'string',
        'relatedAttributeId' => 'string',
        'recommendedValue' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'code' => null,
        'message' => null,
        'longMessage' => null,
        'relatedAttributeId' => null,
        'recommendedValue' => null
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
        'code' => 'code',
        'message' => 'message',
        'longMessage' => 'longMessage',
        'relatedAttributeId' => 'relatedAttributeId',
        'recommendedValue' => 'recommendedValue'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'code' => 'setCode',
        'message' => 'setMessage',
        'longMessage' => 'setLongMessage',
        'relatedAttributeId' => 'setRelatedAttributeId',
        'recommendedValue' => 'setRecommendedValue'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'code' => 'getCode',
        'message' => 'getMessage',
        'longMessage' => 'getLongMessage',
        'relatedAttributeId' => 'getRelatedAttributeId',
        'recommendedValue' => 'getRecommendedValue'
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





    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    public function __construct(array $data = null)
    {
        $this->container['code'] = $data['code'] ?? null;
        $this->container['message'] = $data['message'] ?? null;
        $this->container['longMessage'] = $data['longMessage'] ?? null;
        $this->container['relatedAttributeId'] = $data['relatedAttributeId'] ?? null;
        $this->container['recommendedValue'] = $data['recommendedValue'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['code'] === null) {
            $invalidProperties[] = "'code' can't be null";
        }
        if ((mb_strlen($this->container['code']) > 255)) {
            $invalidProperties[] = "invalid value for 'code', the character length must be smaller than or equal to 255.";
        }

        if ((mb_strlen($this->container['code']) < 1)) {
            $invalidProperties[] = "invalid value for 'code', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['message'] === null) {
            $invalidProperties[] = "'message' can't be null";
        }
        if ((mb_strlen($this->container['message']) > 250)) {
            $invalidProperties[] = "invalid value for 'message', the character length must be smaller than or equal to 250.";
        }

        if ((mb_strlen($this->container['message']) < 1)) {
            $invalidProperties[] = "invalid value for 'message', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['longMessage']) && (mb_strlen($this->container['longMessage']) > 10000)) {
            $invalidProperties[] = "invalid value for 'longMessage', the character length must be smaller than or equal to 10000.";
        }

        if (!is_null($this->container['longMessage']) && (mb_strlen($this->container['longMessage']) < 1)) {
            $invalidProperties[] = "invalid value for 'longMessage', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['relatedAttributeId']) && (mb_strlen($this->container['relatedAttributeId']) > 512)) {
            $invalidProperties[] = "invalid value for 'relatedAttributeId', the character length must be smaller than or equal to 512.";
        }

        if (!is_null($this->container['relatedAttributeId']) && (mb_strlen($this->container['relatedAttributeId']) < 1)) {
            $invalidProperties[] = "invalid value for 'relatedAttributeId', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['recommendedValue']) && (mb_strlen($this->container['recommendedValue']) > 1000)) {
            $invalidProperties[] = "invalid value for 'recommendedValue', the character length must be smaller than or equal to 1000.";
        }

        if (!is_null($this->container['recommendedValue']) && (mb_strlen($this->container['recommendedValue']) < 1)) {
            $invalidProperties[] = "invalid value for 'recommendedValue', the character length must be bigger than or equal to 1.";
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


    public function getCode(): string
    {
        return $this->container['code'];
    }

    public function setCode(string $code): OfferListingFailedError
    {
        $this->container['code'] = $code;
        return $this;
    }


    public function getMessage(): string
    {
        return $this->container['message'];
    }

    public function setMessage(string $message): OfferListingFailedError
    {
        $this->container['message'] = $message;
        return $this;
    }


    public function getLongMessage(): ?string
    {
        return $this->container['longMessage'];
    }

    public function setLongMessage(?string $longMessage): OfferListingFailedError
    {
        $this->container['longMessage'] = $longMessage;
        return $this;
    }


    public function getRelatedAttributeId(): ?string
    {
        return $this->container['relatedAttributeId'];
    }

    public function setRelatedAttributeId(?string $relatedAttributeId): OfferListingFailedError
    {
        $this->container['relatedAttributeId'] = $relatedAttributeId;
        return $this;
    }


    public function getRecommendedValue(): ?string
    {
        return $this->container['recommendedValue'];
    }

    public function setRecommendedValue(?string $recommendedValue): OfferListingFailedError
    {
        $this->container['recommendedValue'] = $recommendedValue;
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
