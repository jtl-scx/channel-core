<?php
/**
 * ReturnProcessingResult
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * SCX Channel API
 *
 * SCX Channel API
 *
 * The version of the OpenAPI document: 1.0.0
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.1.0
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
 * ReturnProcessingResult Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class ReturnProcessingResult implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'ReturnProcessingResult';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param ReturnProcessingError
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'sellerId' => 'string',
        'sellerReturnId' => 'string',
        'isAccepted' => 'bool',
        'processingErrorList' => '\JTL\SCX\Lib\Channel\Client\Model\ReturnProcessingError[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'sellerId' => null,
        'sellerReturnId' => null,
        'isAccepted' => null,
        'processingErrorList' => null
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
        'sellerId' => 'sellerId',
        'sellerReturnId' => 'sellerReturnId',
        'isAccepted' => 'isAccepted',
        'processingErrorList' => 'processingErrorList'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'sellerId' => 'setSellerId',
        'sellerReturnId' => 'setSellerReturnId',
        'isAccepted' => 'setIsAccepted',
        'processingErrorList' => 'setProcessingErrorList'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'sellerId' => 'getSellerId',
        'sellerReturnId' => 'getSellerReturnId',
        'isAccepted' => 'getIsAccepted',
        'processingErrorList' => 'getProcessingErrorList'
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
        $this->container['sellerId'] = $data['sellerId'] ?? null;
        $this->container['sellerReturnId'] = $data['sellerReturnId'] ?? null;
        $this->container['isAccepted'] = $data['isAccepted'] ?? null;
        $this->container['processingErrorList'] = $data['processingErrorList'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['sellerId'] === null) {
            $invalidProperties[] = "'sellerId' can't be null";
        }
        if (!preg_match("/^\\w{1,50}$/", $this->container['sellerId'])) {
            $invalidProperties[] = "invalid value for 'sellerId', must be conform to the pattern /^\\w{1,50}$/.";
        }

        if ($this->container['sellerReturnId'] === null) {
            $invalidProperties[] = "'sellerReturnId' can't be null";
        }
        if ($this->container['isAccepted'] === null) {
            $invalidProperties[] = "'isAccepted' can't be null";
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


    public function getSellerId(): string
    {
        return $this->container['sellerId'];
    }

    public function setSellerId(string $sellerId): ReturnProcessingResult
    {
        $this->container['sellerId'] = $sellerId;
        return $this;
    }


    public function getSellerReturnId(): string
    {
        return $this->container['sellerReturnId'];
    }

    public function setSellerReturnId(string $sellerReturnId): ReturnProcessingResult
    {
        $this->container['sellerReturnId'] = $sellerReturnId;
        return $this;
    }


    public function getIsAccepted(): bool
    {
        return $this->container['isAccepted'];
    }

    public function setIsAccepted(bool $isAccepted): ReturnProcessingResult
    {
        $this->container['isAccepted'] = $isAccepted;
        return $this;
    }


    public function getProcessingErrorList(): ?array
    {
        return $this->container['processingErrorList'];
    }

    public function setProcessingErrorList(?array $processingErrorList): ReturnProcessingResult
    {
        $this->container['processingErrorList'] = $processingErrorList;
        return $this;
    }

    public function offsetExists($offset)
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
    public function offsetGet($offset)
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
    public function offsetSet($offset, $value)
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
    public function offsetUnset($offset)
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
    public function jsonSerialize()
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
    public function toHeaderValue()
    {
        return json_encode($this->jsonSerialize());
    }
}
