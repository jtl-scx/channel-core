<?php
/**
 * ChannelUpdateFeatureList
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
 * ChannelUpdateFeatureList Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class ChannelUpdateFeatureList implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'ChannelUpdate_featureList';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'invoiceDocumentTransfer' => 'string',
        'priceUpdatesSupported' => 'bool',
        'quantityPriceSupported' => 'bool',
        'remainingQuanitySupported' => 'bool',
        'variationsSupported' => 'bool',
        'returnTrackingRequired' => 'bool',
        'allowCombineOrders' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'invoiceDocumentTransfer' => null,
        'priceUpdatesSupported' => null,
        'quantityPriceSupported' => null,
        'remainingQuanitySupported' => null,
        'variationsSupported' => null,
        'returnTrackingRequired' => null,
        'allowCombineOrders' => null
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
        'invoiceDocumentTransfer' => 'invoiceDocumentTransfer',
        'priceUpdatesSupported' => 'priceUpdatesSupported',
        'quantityPriceSupported' => 'quantityPriceSupported',
        'remainingQuanitySupported' => 'remainingQuanitySupported',
        'variationsSupported' => 'variationsSupported',
        'returnTrackingRequired' => 'returnTrackingRequired',
        'allowCombineOrders' => 'allowCombineOrders'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'invoiceDocumentTransfer' => 'setInvoiceDocumentTransfer',
        'priceUpdatesSupported' => 'setPriceUpdatesSupported',
        'quantityPriceSupported' => 'setQuantityPriceSupported',
        'remainingQuanitySupported' => 'setRemainingQuanitySupported',
        'variationsSupported' => 'setVariationsSupported',
        'returnTrackingRequired' => 'setReturnTrackingRequired',
        'allowCombineOrders' => 'setAllowCombineOrders'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'invoiceDocumentTransfer' => 'getInvoiceDocumentTransfer',
        'priceUpdatesSupported' => 'getPriceUpdatesSupported',
        'quantityPriceSupported' => 'getQuantityPriceSupported',
        'remainingQuanitySupported' => 'getRemainingQuanitySupported',
        'variationsSupported' => 'getVariationsSupported',
        'returnTrackingRequired' => 'getReturnTrackingRequired',
        'allowCombineOrders' => 'getAllowCombineOrders'
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

    const INVOICE_DOCUMENT_TRANSFER_NOT_SUPPORTED = 'not-supported';
    const INVOICE_DOCUMENT_TRANSFER_FROM_CHANNEL = 'from-channel';
    const INVOICE_DOCUMENT_TRANSFER_FROM_SELLER = 'from-seller';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getInvoiceDocumentTransferAllowableValues()
    {
        return [
            self::INVOICE_DOCUMENT_TRANSFER_NOT_SUPPORTED,
            self::INVOICE_DOCUMENT_TRANSFER_FROM_CHANNEL,
            self::INVOICE_DOCUMENT_TRANSFER_FROM_SELLER,
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
        $this->container['invoiceDocumentTransfer'] = $data['invoiceDocumentTransfer'] ?? self::INVOICE_DOCUMENT_TRANSFER_NOT_SUPPORTED;
        $this->container['priceUpdatesSupported'] = $data['priceUpdatesSupported'] ?? false;
        $this->container['quantityPriceSupported'] = $data['quantityPriceSupported'] ?? false;
        $this->container['remainingQuanitySupported'] = $data['remainingQuanitySupported'] ?? false;
        $this->container['variationsSupported'] = $data['variationsSupported'] ?? false;
        $this->container['returnTrackingRequired'] = $data['returnTrackingRequired'] ?? false;
        $this->container['allowCombineOrders'] = $data['allowCombineOrders'] ?? false;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getInvoiceDocumentTransferAllowableValues();
        if (!is_null($this->container['invoiceDocumentTransfer']) && !in_array($this->container['invoiceDocumentTransfer'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'invoiceDocumentTransfer', must be one of '%s'",
                $this->container['invoiceDocumentTransfer'],
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


    public function getInvoiceDocumentTransfer(): ?string
    {
        return $this->container['invoiceDocumentTransfer'];
    }

    public function setInvoiceDocumentTransfer(?string $invoiceDocumentTransfer): ChannelUpdateFeatureList
    {
        $this->container['invoiceDocumentTransfer'] = $invoiceDocumentTransfer;
        return $this;
    }


    public function getPriceUpdatesSupported(): ?bool
    {
        return $this->container['priceUpdatesSupported'];
    }

    public function setPriceUpdatesSupported(?bool $priceUpdatesSupported): ChannelUpdateFeatureList
    {
        $this->container['priceUpdatesSupported'] = $priceUpdatesSupported;
        return $this;
    }


    public function getQuantityPriceSupported(): ?bool
    {
        return $this->container['quantityPriceSupported'];
    }

    public function setQuantityPriceSupported(?bool $quantityPriceSupported): ChannelUpdateFeatureList
    {
        $this->container['quantityPriceSupported'] = $quantityPriceSupported;
        return $this;
    }


    public function getRemainingQuanitySupported(): ?bool
    {
        return $this->container['remainingQuanitySupported'];
    }

    public function setRemainingQuanitySupported(?bool $remainingQuanitySupported): ChannelUpdateFeatureList
    {
        $this->container['remainingQuanitySupported'] = $remainingQuanitySupported;
        return $this;
    }


    public function getVariationsSupported(): ?bool
    {
        return $this->container['variationsSupported'];
    }

    public function setVariationsSupported(?bool $variationsSupported): ChannelUpdateFeatureList
    {
        $this->container['variationsSupported'] = $variationsSupported;
        return $this;
    }


    public function getReturnTrackingRequired(): ?bool
    {
        return $this->container['returnTrackingRequired'];
    }

    public function setReturnTrackingRequired(?bool $returnTrackingRequired): ChannelUpdateFeatureList
    {
        $this->container['returnTrackingRequired'] = $returnTrackingRequired;
        return $this;
    }


    public function getAllowCombineOrders(): ?bool
    {
        return $this->container['allowCombineOrders'];
    }

    public function setAllowCombineOrders(?bool $allowCombineOrders): ChannelUpdateFeatureList
    {
        $this->container['allowCombineOrders'] = $allowCombineOrders;
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


