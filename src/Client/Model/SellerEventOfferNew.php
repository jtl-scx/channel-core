<?php
/**
 * SellerEventOfferNew
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
 * SellerEventOfferNew Class Doc Comment
 *
 * @category Class
 * @description List Offer on Channel.  If your current channel implementation process listing in asychronous manner it is recommended to call &#x60;/channel/offer/received&#x60; afterwards to mark wating Offers as in-progress. If a channel process an Offer directly you do not need to mark a Offer as &#x60;in-progress&#x60;. But it is important to mark an Offer as &#x60;successful&#x60; listed. If there are any errors during the listing process it is importand to mark a offer as &#x60;failed&#x60;.
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class SellerEventOfferNew implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'SellerEventOfferNew';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param PriceContainer
      * @param ChannelAttribute
      * @param Variation
      * @param Price
      * @param ProductAttribute
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
        'variationList' => '\JTL\SCX\Lib\Channel\Client\Model\Variation[]',
        'sku' => 'string',
        'gtin' => 'string',
        'mpn' => 'string',
        'isbn' => 'string',
        'brand' => 'string',
        'srp' => '\JTL\SCX\Lib\Channel\Client\Model\Price',
        'productAttributeList' => '\JTL\SCX\Lib\Channel\Client\Model\ProductAttribute[]'
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
        'variationList' => null,
        'sku' => null,
        'gtin' => null,
        'mpn' => null,
        'isbn' => null,
        'brand' => null,
        'srp' => null,
        'productAttributeList' => null
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
        'variationList' => 'variationList',
        'sku' => 'sku',
        'gtin' => 'gtin',
        'mpn' => 'mpn',
        'isbn' => 'isbn',
        'brand' => 'brand',
        'srp' => 'srp',
        'productAttributeList' => 'productAttributeList'
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
        'variationList' => 'setVariationList',
        'sku' => 'setSku',
        'gtin' => 'setGtin',
        'mpn' => 'setMpn',
        'isbn' => 'setIsbn',
        'brand' => 'setBrand',
        'srp' => 'setSrp',
        'productAttributeList' => 'setProductAttributeList'
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
        'variationList' => 'getVariationList',
        'sku' => 'getSku',
        'gtin' => 'getGtin',
        'mpn' => 'getMpn',
        'isbn' => 'getIsbn',
        'brand' => 'getBrand',
        'srp' => 'getSrp',
        'productAttributeList' => 'getProductAttributeList'
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
        $this->container['sku'] = $data['sku'] ?? null;
        $this->container['gtin'] = $data['gtin'] ?? null;
        $this->container['mpn'] = $data['mpn'] ?? null;
        $this->container['isbn'] = $data['isbn'] ?? null;
        $this->container['brand'] = $data['brand'] ?? null;
        $this->container['srp'] = $data['srp'] ?? null;
        $this->container['productAttributeList'] = $data['productAttributeList'] ?? null;
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
        if (!is_null($this->container['title']) && (mb_strlen($this->container['title']) > 512)) {
            $invalidProperties[] = "invalid value for 'title', the character length must be smaller than or equal to 512.";
        }

        if (!is_null($this->container['title']) && (mb_strlen($this->container['title']) < 1)) {
            $invalidProperties[] = "invalid value for 'title', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['subTitle']) && (mb_strlen($this->container['subTitle']) > 1024)) {
            $invalidProperties[] = "invalid value for 'subTitle', the character length must be smaller than or equal to 1024.";
        }

        if (!is_null($this->container['description']) && (mb_strlen($this->container['description']) > 50000)) {
            $invalidProperties[] = "invalid value for 'description', the character length must be smaller than or equal to 50000.";
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

    public function setSellerId(string $sellerId): SellerEventOfferNew
    {
        $this->container['sellerId'] = $sellerId;
        return $this;
    }


    public function getOfferId(): int
    {
        return $this->container['offerId'];
    }

    public function setOfferId(int $offerId): SellerEventOfferNew
    {
        $this->container['offerId'] = $offerId;
        return $this;
    }


    public function getParentOfferId(): ?int
    {
        return $this->container['parentOfferId'];
    }

    public function setParentOfferId(?int $parentOfferId): SellerEventOfferNew
    {
        $this->container['parentOfferId'] = $parentOfferId;
        return $this;
    }


    public function getChannelOfferId(): ?string
    {
        return $this->container['channelOfferId'];
    }

    public function setChannelOfferId(?string $channelOfferId): SellerEventOfferNew
    {
        $this->container['channelOfferId'] = $channelOfferId;
        return $this;
    }


    public function getChannelCategoryId(): ?string
    {
        return $this->container['channelCategoryId'];
    }

    public function setChannelCategoryId(?string $channelCategoryId): SellerEventOfferNew
    {
        $this->container['channelCategoryId'] = $channelCategoryId;
        return $this;
    }


    public function getQuantity(): ?string
    {
        return $this->container['quantity'];
    }

    public function setQuantity(?string $quantity): SellerEventOfferNew
    {
        $this->container['quantity'] = $quantity;
        return $this;
    }


    public function getTaxPercent(): ?string
    {
        return $this->container['taxPercent'];
    }

    public function setTaxPercent(?string $taxPercent): SellerEventOfferNew
    {
        $this->container['taxPercent'] = $taxPercent;
        return $this;
    }


    public function getPriceList(): array
    {
        return $this->container['priceList'];
    }

    public function setPriceList(array $priceList): SellerEventOfferNew
    {
        $this->container['priceList'] = $priceList;
        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->container['title'];
    }

    public function setTitle(?string $title): SellerEventOfferNew
    {
        $this->container['title'] = $title;
        return $this;
    }


    public function getSubTitle(): ?string
    {
        return $this->container['subTitle'];
    }

    public function setSubTitle(?string $subTitle): SellerEventOfferNew
    {
        $this->container['subTitle'] = $subTitle;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->container['description'];
    }

    public function setDescription(?string $description): SellerEventOfferNew
    {
        $this->container['description'] = $description;
        return $this;
    }


    public function getMainPicture(): ?string
    {
        return $this->container['mainPicture'];
    }

    public function setMainPicture(?string $mainPicture): SellerEventOfferNew
    {
        $this->container['mainPicture'] = $mainPicture;
        return $this;
    }


    public function getPictureList(): ?array
    {
        return $this->container['pictureList'];
    }

    public function setPictureList(?array $pictureList): SellerEventOfferNew
    {
        $this->container['pictureList'] = $pictureList;
        return $this;
    }


    public function getChannelAttributeList(): ?array
    {
        return $this->container['channelAttributeList'];
    }

    public function setChannelAttributeList(?array $channelAttributeList): SellerEventOfferNew
    {
        $this->container['channelAttributeList'] = $channelAttributeList;
        return $this;
    }


    public function getVariationList(): ?array
    {
        return $this->container['variationList'];
    }

    public function setVariationList(?array $variationList): SellerEventOfferNew
    {
        $this->container['variationList'] = $variationList;
        return $this;
    }


    public function getSku(): string
    {
        return $this->container['sku'];
    }

    public function setSku(string $sku): SellerEventOfferNew
    {
        $this->container['sku'] = $sku;
        return $this;
    }


    public function getGtin(): ?string
    {
        return $this->container['gtin'];
    }

    public function setGtin(?string $gtin): SellerEventOfferNew
    {
        $this->container['gtin'] = $gtin;
        return $this;
    }


    public function getMpn(): ?string
    {
        return $this->container['mpn'];
    }

    public function setMpn(?string $mpn): SellerEventOfferNew
    {
        $this->container['mpn'] = $mpn;
        return $this;
    }


    public function getIsbn(): ?string
    {
        return $this->container['isbn'];
    }

    public function setIsbn(?string $isbn): SellerEventOfferNew
    {
        $this->container['isbn'] = $isbn;
        return $this;
    }


    public function getBrand(): ?string
    {
        return $this->container['brand'];
    }

    public function setBrand(?string $brand): SellerEventOfferNew
    {
        $this->container['brand'] = $brand;
        return $this;
    }


    public function getSrp(): ?Price
    {
        return $this->container['srp'];
    }

    public function setSrp(?Price $srp): SellerEventOfferNew
    {
        $this->container['srp'] = $srp;
        return $this;
    }


    public function getProductAttributeList(): ?array
    {
        return $this->container['productAttributeList'];
    }

    public function setProductAttributeList(?array $productAttributeList): SellerEventOfferNew
    {
        $this->container['productAttributeList'] = $productAttributeList;
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


