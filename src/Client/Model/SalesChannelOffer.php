<?php
/**
 * SalesChannelOffer
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
 * SalesChannelOffer Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class SalesChannelOffer implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'SalesChannelOffer';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param PriceContainer
      * @param ChannelAttribute
      * @param Variation
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'sellerId' => 'string',
        'offerId' => 'int',
        'parentOfferId' => 'int',
        'channelOfferId' => 'string',
        'channelCategoryId' => 'string',
        'quantity' => 'string',
        'taxPercent' => 'string',
        'priceList' => '\JTL\SCX\Lib\Channel\Client\Model\PriceContainer[]',
        'title' => 'string',
        'subTitle' => 'string',
        'description' => 'string',
        'mainPicture' => 'string',
        'pictureList' => 'string[]',
        'channelAttributeList' => '\JTL\SCX\Lib\Channel\Client\Model\ChannelAttribute[]',
        'variationList' => '\JTL\SCX\Lib\Channel\Client\Model\Variation[]'
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
        'offerId' => 'int64',
        'parentOfferId' => 'int64',
        'channelOfferId' => null,
        'channelCategoryId' => null,
        'quantity' => null,
        'taxPercent' => null,
        'priceList' => null,
        'title' => null,
        'subTitle' => null,
        'description' => null,
        'mainPicture' => null,
        'pictureList' => null,
        'channelAttributeList' => null,
        'variationList' => null
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
        'offerId' => 'offerId',
        'parentOfferId' => 'parentOfferId',
        'channelOfferId' => 'channelOfferId',
        'channelCategoryId' => 'channelCategoryId',
        'quantity' => 'quantity',
        'taxPercent' => 'taxPercent',
        'priceList' => 'priceList',
        'title' => 'title',
        'subTitle' => 'subTitle',
        'description' => 'description',
        'mainPicture' => 'mainPicture',
        'pictureList' => 'pictureList',
        'channelAttributeList' => 'channelAttributeList',
        'variationList' => 'variationList'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'sellerId' => 'setSellerId',
        'offerId' => 'setOfferId',
        'parentOfferId' => 'setParentOfferId',
        'channelOfferId' => 'setChannelOfferId',
        'channelCategoryId' => 'setChannelCategoryId',
        'quantity' => 'setQuantity',
        'taxPercent' => 'setTaxPercent',
        'priceList' => 'setPriceList',
        'title' => 'setTitle',
        'subTitle' => 'setSubTitle',
        'description' => 'setDescription',
        'mainPicture' => 'setMainPicture',
        'pictureList' => 'setPictureList',
        'channelAttributeList' => 'setChannelAttributeList',
        'variationList' => 'setVariationList'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'sellerId' => 'getSellerId',
        'offerId' => 'getOfferId',
        'parentOfferId' => 'getParentOfferId',
        'channelOfferId' => 'getChannelOfferId',
        'channelCategoryId' => 'getChannelCategoryId',
        'quantity' => 'getQuantity',
        'taxPercent' => 'getTaxPercent',
        'priceList' => 'getPriceList',
        'title' => 'getTitle',
        'subTitle' => 'getSubTitle',
        'description' => 'getDescription',
        'mainPicture' => 'getMainPicture',
        'pictureList' => 'getPictureList',
        'channelAttributeList' => 'getChannelAttributeList',
        'variationList' => 'getVariationList'
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
        $this->container['offerId'] = $data['offerId'] ?? null;
        $this->container['parentOfferId'] = $data['parentOfferId'] ?? null;
        $this->container['channelOfferId'] = $data['channelOfferId'] ?? null;
        $this->container['channelCategoryId'] = $data['channelCategoryId'] ?? null;
        $this->container['quantity'] = $data['quantity'] ?? null;
        $this->container['taxPercent'] = $data['taxPercent'] ?? null;
        $this->container['priceList'] = $data['priceList'] ?? null;
        $this->container['title'] = $data['title'] ?? null;
        $this->container['subTitle'] = $data['subTitle'] ?? null;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['mainPicture'] = $data['mainPicture'] ?? null;
        $this->container['pictureList'] = $data['pictureList'] ?? null;
        $this->container['channelAttributeList'] = $data['channelAttributeList'] ?? null;
        $this->container['variationList'] = $data['variationList'] ?? null;
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

        if ($this->container['offerId'] === null) {
            $invalidProperties[] = "'offerId' can't be null";
        }
        if (($this->container['offerId'] < 1)) {
            $invalidProperties[] = "invalid value for 'offerId', must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['parentOfferId']) && ($this->container['parentOfferId'] < 1)) {
            $invalidProperties[] = "invalid value for 'parentOfferId', must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['channelOfferId']) && (mb_strlen($this->container['channelOfferId']) > 50)) {
            $invalidProperties[] = "invalid value for 'channelOfferId', the character length must be smaller than or equal to 50.";
        }

        if (!is_null($this->container['channelOfferId']) && (mb_strlen($this->container['channelOfferId']) < 1)) {
            $invalidProperties[] = "invalid value for 'channelOfferId', the character length must be bigger than or equal to 1.";
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


    public function getSellerId(): string
    {
        return $this->container['sellerId'];
    }

    public function setSellerId(string $sellerId): SalesChannelOffer
    {
        $this->container['sellerId'] = $sellerId;
        return $this;
    }


    public function getOfferId(): int
    {
        return $this->container['offerId'];
    }

    public function setOfferId(int $offerId): SalesChannelOffer
    {
        $this->container['offerId'] = $offerId;
        return $this;
    }


    public function getParentOfferId(): ?int
    {
        return $this->container['parentOfferId'];
    }

    public function setParentOfferId(?int $parentOfferId): SalesChannelOffer
    {
        $this->container['parentOfferId'] = $parentOfferId;
        return $this;
    }


    public function getChannelOfferId(): ?string
    {
        return $this->container['channelOfferId'];
    }

    public function setChannelOfferId(?string $channelOfferId): SalesChannelOffer
    {
        $this->container['channelOfferId'] = $channelOfferId;
        return $this;
    }


    public function getChannelCategoryId(): ?string
    {
        return $this->container['channelCategoryId'];
    }

    public function setChannelCategoryId(?string $channelCategoryId): SalesChannelOffer
    {
        $this->container['channelCategoryId'] = $channelCategoryId;
        return $this;
    }


    public function getQuantity(): ?string
    {
        return $this->container['quantity'];
    }

    public function setQuantity(?string $quantity): SalesChannelOffer
    {
        $this->container['quantity'] = $quantity;
        return $this;
    }


    public function getTaxPercent(): ?string
    {
        return $this->container['taxPercent'];
    }

    public function setTaxPercent(?string $taxPercent): SalesChannelOffer
    {
        $this->container['taxPercent'] = $taxPercent;
        return $this;
    }


    public function getPriceList(): array
    {
        return $this->container['priceList'];
    }

    public function setPriceList(array $priceList): SalesChannelOffer
    {
        $this->container['priceList'] = $priceList;
        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->container['title'];
    }

    public function setTitle(?string $title): SalesChannelOffer
    {
        $this->container['title'] = $title;
        return $this;
    }


    public function getSubTitle(): ?string
    {
        return $this->container['subTitle'];
    }

    public function setSubTitle(?string $subTitle): SalesChannelOffer
    {
        $this->container['subTitle'] = $subTitle;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->container['description'];
    }

    public function setDescription(?string $description): SalesChannelOffer
    {
        $this->container['description'] = $description;
        return $this;
    }


    public function getMainPicture(): ?string
    {
        return $this->container['mainPicture'];
    }

    public function setMainPicture(?string $mainPicture): SalesChannelOffer
    {
        $this->container['mainPicture'] = $mainPicture;
        return $this;
    }


    public function getPictureList(): ?array
    {
        return $this->container['pictureList'];
    }

    public function setPictureList(?array $pictureList): SalesChannelOffer
    {
        $this->container['pictureList'] = $pictureList;
        return $this;
    }


    public function getChannelAttributeList(): ?array
    {
        return $this->container['channelAttributeList'];
    }

    public function setChannelAttributeList(?array $channelAttributeList): SalesChannelOffer
    {
        $this->container['channelAttributeList'] = $channelAttributeList;
        return $this;
    }


    public function getVariationList(): ?array
    {
        return $this->container['variationList'];
    }

    public function setVariationList(?array $variationList): SalesChannelOffer
    {
        $this->container['variationList'] = $variationList;
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