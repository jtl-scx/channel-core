<?php
/**
 * ReturnReceivedOrderItem
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
 * ReturnReceivedOrderItem Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class ReturnReceivedOrderItem implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'ReturnReceivedOrderItem';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param ReturnReason
      * @param Condition
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'orderItemId' => 'string',
        'quantity' => 'string',
        'returnReason' => '\JTL\SCX\Lib\Channel\Client\Model\ReturnReason',
        'note' => 'string',
        'condition' => '\JTL\SCX\Lib\Channel\Client\Model\Condition',
        'acceptReturn' => 'bool',
        'requireReturnShipping' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'orderItemId' => 'string',
        'quantity' => null,
        'returnReason' => null,
        'note' => null,
        'condition' => null,
        'acceptReturn' => null,
        'requireReturnShipping' => null
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
        'orderItemId' => 'orderItemId',
        'quantity' => 'quantity',
        'returnReason' => 'returnReason',
        'note' => 'note',
        'condition' => 'condition',
        'acceptReturn' => 'acceptReturn',
        'requireReturnShipping' => 'requireReturnShipping'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'orderItemId' => 'setOrderItemId',
        'quantity' => 'setQuantity',
        'returnReason' => 'setReturnReason',
        'note' => 'setNote',
        'condition' => 'setCondition',
        'acceptReturn' => 'setAcceptReturn',
        'requireReturnShipping' => 'setRequireReturnShipping'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'orderItemId' => 'getOrderItemId',
        'quantity' => 'getQuantity',
        'returnReason' => 'getReturnReason',
        'note' => 'getNote',
        'condition' => 'getCondition',
        'acceptReturn' => 'getAcceptReturn',
        'requireReturnShipping' => 'getRequireReturnShipping'
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
        $this->container['orderItemId'] = $data['orderItemId'] ?? null;
        $this->container['quantity'] = $data['quantity'] ?? null;
        $this->container['returnReason'] = $data['returnReason'] ?? null;
        $this->container['note'] = $data['note'] ?? null;
        $this->container['condition'] = $data['condition'] ?? null;
        $this->container['acceptReturn'] = $data['acceptReturn'] ?? null;
        $this->container['requireReturnShipping'] = $data['requireReturnShipping'] ?? true;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['orderItemId'] === null) {
            $invalidProperties[] = "'orderItemId' can't be null";
        }
        if ((mb_strlen($this->container['orderItemId']) > 50)) {
            $invalidProperties[] = "invalid value for 'orderItemId', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['orderItemId']) < 1)) {
            $invalidProperties[] = "invalid value for 'orderItemId', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['quantity'] === null) {
            $invalidProperties[] = "'quantity' can't be null";
        }
        if ($this->container['returnReason'] === null) {
            $invalidProperties[] = "'returnReason' can't be null";
        }
        if (!is_null($this->container['note']) && (mb_strlen($this->container['note']) > 1024)) {
            $invalidProperties[] = "invalid value for 'note', the character length must be smaller than or equal to 1024.";
        }

        if ($this->container['condition'] === null) {
            $invalidProperties[] = "'condition' can't be null";
        }
        if ($this->container['acceptReturn'] === null) {
            $invalidProperties[] = "'acceptReturn' can't be null";
        }
        if ($this->container['requireReturnShipping'] === null) {
            $invalidProperties[] = "'requireReturnShipping' can't be null";
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


    public function getOrderItemId(): string
    {
        return $this->container['orderItemId'];
    }

    public function setOrderItemId(string $orderItemId): ReturnReceivedOrderItem
    {
        $this->container['orderItemId'] = $orderItemId;
        return $this;
    }


    public function getQuantity(): string
    {
        return $this->container['quantity'];
    }

    public function setQuantity(string $quantity): ReturnReceivedOrderItem
    {
        $this->container['quantity'] = $quantity;
        return $this;
    }


    public function getReturnReason(): ReturnReason
    {
        return $this->container['returnReason'];
    }

    public function setReturnReason(ReturnReason $returnReason): ReturnReceivedOrderItem
    {
        $this->container['returnReason'] = $returnReason;
        return $this;
    }


    public function getNote(): ?string
    {
        return $this->container['note'];
    }

    public function setNote(?string $note): ReturnReceivedOrderItem
    {
        $this->container['note'] = $note;
        return $this;
    }


    public function getCondition(): Condition
    {
        return $this->container['condition'];
    }

    public function setCondition(Condition $condition): ReturnReceivedOrderItem
    {
        $this->container['condition'] = $condition;
        return $this;
    }


    public function getAcceptReturn(): bool
    {
        return $this->container['acceptReturn'];
    }

    public function setAcceptReturn(bool $acceptReturn): ReturnReceivedOrderItem
    {
        $this->container['acceptReturn'] = $acceptReturn;
        return $this;
    }


    public function getRequireReturnShipping(): bool
    {
        return $this->container['requireReturnShipping'];
    }

    public function setRequireReturnShipping(bool $requireReturnShipping): ReturnReceivedOrderItem
    {
        $this->container['requireReturnShipping'] = $requireReturnShipping;
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
