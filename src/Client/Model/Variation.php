<?php
/**
 * Variation
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
 * Variation Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class Variation implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Variation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param ChannelAttribute
      * @param PriceContainer
      * @param ChannelAttribute
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'offerId' => 'int',
        'sku' => 'string',
        'gtin' => 'string',
        'variationDimensionList' => '\JTL\SCX\Lib\Channel\Client\Model\ChannelAttribute[]',
        'quantity' => 'string',
        'priceList' => '\JTL\SCX\Lib\Channel\Client\Model\PriceContainer[]',
        'taxPercent' => 'string',
        'pictureList' => 'string[]',
        'title' => 'string',
        'subTitle' => 'string',
        'description' => 'string',
        'channelAttributeList' => '\JTL\SCX\Lib\Channel\Client\Model\ChannelAttribute[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'offerId' => 'int64',
        'sku' => null,
        'gtin' => null,
        'variationDimensionList' => null,
        'quantity' => null,
        'priceList' => null,
        'taxPercent' => null,
        'pictureList' => null,
        'title' => null,
        'subTitle' => null,
        'description' => null,
        'channelAttributeList' => null
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
        'offerId' => 'offerId',
        'sku' => 'sku',
        'gtin' => 'gtin',
        'variationDimensionList' => 'variationDimensionList',
        'quantity' => 'quantity',
        'priceList' => 'priceList',
        'taxPercent' => 'taxPercent',
        'pictureList' => 'pictureList',
        'title' => 'title',
        'subTitle' => 'subTitle',
        'description' => 'description',
        'channelAttributeList' => 'channelAttributeList'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'offerId' => 'setOfferId',
        'sku' => 'setSku',
        'gtin' => 'setGtin',
        'variationDimensionList' => 'setVariationDimensionList',
        'quantity' => 'setQuantity',
        'priceList' => 'setPriceList',
        'taxPercent' => 'setTaxPercent',
        'pictureList' => 'setPictureList',
        'title' => 'setTitle',
        'subTitle' => 'setSubTitle',
        'description' => 'setDescription',
        'channelAttributeList' => 'setChannelAttributeList'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'offerId' => 'getOfferId',
        'sku' => 'getSku',
        'gtin' => 'getGtin',
        'variationDimensionList' => 'getVariationDimensionList',
        'quantity' => 'getQuantity',
        'priceList' => 'getPriceList',
        'taxPercent' => 'getTaxPercent',
        'pictureList' => 'getPictureList',
        'title' => 'getTitle',
        'subTitle' => 'getSubTitle',
        'description' => 'getDescription',
        'channelAttributeList' => 'getChannelAttributeList'
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
        $this->container['offerId'] = $data['offerId'] ?? null;
        $this->container['sku'] = $data['sku'] ?? null;
        $this->container['gtin'] = $data['gtin'] ?? null;
        $this->container['variationDimensionList'] = $data['variationDimensionList'] ?? null;
        $this->container['quantity'] = $data['quantity'] ?? null;
        $this->container['priceList'] = $data['priceList'] ?? null;
        $this->container['taxPercent'] = $data['taxPercent'] ?? null;
        $this->container['pictureList'] = $data['pictureList'] ?? null;
        $this->container['title'] = $data['title'] ?? null;
        $this->container['subTitle'] = $data['subTitle'] ?? null;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['channelAttributeList'] = $data['channelAttributeList'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['offerId'] === null) {
            $invalidProperties[] = "'offerId' can't be null";
        }
        if (($this->container['offerId'] < 1)) {
            $invalidProperties[] = "invalid value for 'offerId', must be bigger than or equal to 1.";
        }

        if ($this->container['sku'] === null) {
            $invalidProperties[] = "'sku' can't be null";
        }
        if ((mb_strlen($this->container['sku']) > 150)) {
            $invalidProperties[] = "invalid value for 'sku', the character length must be smaller than or equal to 150.";
        }

        if ((mb_strlen($this->container['sku']) < 1)) {
            $invalidProperties[] = "invalid value for 'sku', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['variationDimensionList'] === null) {
            $invalidProperties[] = "'variationDimensionList' can't be null";
        }
        if ($this->container['quantity'] === null) {
            $invalidProperties[] = "'quantity' can't be null";
        }
        if ($this->container['priceList'] === null) {
            $invalidProperties[] = "'priceList' can't be null";
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


    public function getOfferId(): int
    {
        return $this->container['offerId'];
    }

    public function setOfferId(int $offerId): Variation
    {
        $this->container['offerId'] = $offerId;
        return $this;
    }


    public function getSku(): string
    {
        return $this->container['sku'];
    }

    public function setSku(string $sku): Variation
    {
        $this->container['sku'] = $sku;
        return $this;
    }


    public function getGtin(): ?string
    {
        return $this->container['gtin'];
    }

    public function setGtin(?string $gtin): Variation
    {
        $this->container['gtin'] = $gtin;
        return $this;
    }


    public function getVariationDimensionList(): array
    {
        return $this->container['variationDimensionList'];
    }

    public function setVariationDimensionList(array $variationDimensionList): Variation
    {
        $this->container['variationDimensionList'] = $variationDimensionList;
        return $this;
    }


    public function getQuantity(): string
    {
        return $this->container['quantity'];
    }

    public function setQuantity(string $quantity): Variation
    {
        $this->container['quantity'] = $quantity;
        return $this;
    }


    public function getPriceList(): array
    {
        return $this->container['priceList'];
    }

    public function setPriceList(array $priceList): Variation
    {
        $this->container['priceList'] = $priceList;
        return $this;
    }


    public function getTaxPercent(): ?string
    {
        return $this->container['taxPercent'];
    }

    public function setTaxPercent(?string $taxPercent): Variation
    {
        $this->container['taxPercent'] = $taxPercent;
        return $this;
    }


    public function getPictureList(): ?array
    {
        return $this->container['pictureList'];
    }

    public function setPictureList(?array $pictureList): Variation
    {
        $this->container['pictureList'] = $pictureList;
        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->container['title'];
    }

    public function setTitle(?string $title): Variation
    {
        $this->container['title'] = $title;
        return $this;
    }


    public function getSubTitle(): ?string
    {
        return $this->container['subTitle'];
    }

    public function setSubTitle(?string $subTitle): Variation
    {
        $this->container['subTitle'] = $subTitle;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->container['description'];
    }

    public function setDescription(?string $description): Variation
    {
        $this->container['description'] = $description;
        return $this;
    }


    public function getChannelAttributeList(): ?array
    {
        return $this->container['channelAttributeList'];
    }

    public function setChannelAttributeList(?array $channelAttributeList): Variation
    {
        $this->container['channelAttributeList'] = $channelAttributeList;
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
