<?php
/**
 * SystemEventNotification
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
 * SystemEventNotification Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class SystemEventNotification implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'SystemEventNotification';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'channel' => 'string',
        'sellerId' => 'string',
        'message' => 'string',
        'severity' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'channel' => null,
        'sellerId' => null,
        'message' => null,
        'severity' => null
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
        'channel' => 'channel',
        'sellerId' => 'sellerId',
        'message' => 'message',
        'severity' => 'severity'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'channel' => 'setChannel',
        'sellerId' => 'setSellerId',
        'message' => 'setMessage',
        'severity' => 'setSeverity'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'channel' => 'getChannel',
        'sellerId' => 'getSellerId',
        'message' => 'getMessage',
        'severity' => 'getSeverity'
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

    const SEVERITY_INFO = 'INFO';
    const SEVERITY_WARNING = 'WARNING';
    const SEVERITY_ERROR = 'ERROR';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getSeverityAllowableValues()
    {
        return [
            self::SEVERITY_INFO,
            self::SEVERITY_WARNING,
            self::SEVERITY_ERROR,
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
        $this->container['channel'] = $data['channel'] ?? null;
        $this->container['sellerId'] = $data['sellerId'] ?? null;
        $this->container['message'] = $data['message'] ?? null;
        $this->container['severity'] = $data['severity'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['channel'] === null) {
            $invalidProperties[] = "'channel' can't be null";
        }
        if (!preg_match("/^\\w{5,15}$/", $this->container['channel'])) {
            $invalidProperties[] = "invalid value for 'channel', must be conform to the pattern /^\\w{5,15}$/.";
        }

        if ($this->container['sellerId'] === null) {
            $invalidProperties[] = "'sellerId' can't be null";
        }
        if (!preg_match("/^\\w{1,50}$/", $this->container['sellerId'])) {
            $invalidProperties[] = "invalid value for 'sellerId', must be conform to the pattern /^\\w{1,50}$/.";
        }

        if ($this->container['message'] === null) {
            $invalidProperties[] = "'message' can't be null";
        }
        if ($this->container['severity'] === null) {
            $invalidProperties[] = "'severity' can't be null";
        }
        $allowedValues = $this->getSeverityAllowableValues();
        if (!is_null($this->container['severity']) && !in_array($this->container['severity'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'severity', must be one of '%s'",
                $this->container['severity'],
                implode("', '", $allowedValues)
            );
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


    public function getChannel(): string
    {
        return $this->container['channel'];
    }

    public function setChannel(string $channel): SystemEventNotification
    {
        $this->container['channel'] = $channel;
        return $this;
    }


    public function getSellerId(): string
    {
        return $this->container['sellerId'];
    }

    public function setSellerId(string $sellerId): SystemEventNotification
    {
        $this->container['sellerId'] = $sellerId;
        return $this;
    }


    public function getMessage(): string
    {
        return $this->container['message'];
    }

    public function setMessage(string $message): SystemEventNotification
    {
        $this->container['message'] = $message;
        return $this;
    }


    public function getSeverity(): string
    {
        return $this->container['severity'];
    }

    public function setSeverity(string $severity): SystemEventNotification
    {
        $this->container['severity'] = $severity;
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
