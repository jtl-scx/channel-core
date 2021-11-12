<?php
/**
 * SalesChannelBase
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
 * SalesChannelBase Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class SalesChannelBase implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'SalesChannelBase';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @param ChannelUpdateFeatureList
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'visibility' => 'string',
        'currency' => 'string',
        'marketplaceList' => 'string[]',
        'supportedLanguages' => 'string[]',
        'displayName' => 'string',
        'website' => 'string',
        'supportContact' => 'string',
        'vendor' => 'string',
        'signUpUrl' => 'string',
        'updateUrl' => 'string',
        'featureList' => '\JTL\SCX\Lib\Channel\Client\Model\ChannelUpdateFeatureList'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'visibility' => null,
        'currency' => null,
        'marketplaceList' => null,
        'supportedLanguages' => null,
        'displayName' => null,
        'website' => 'uri',
        'supportContact' => 'email',
        'vendor' => null,
        'signUpUrl' => null,
        'updateUrl' => null,
        'featureList' => null
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
        'visibility' => 'visibility',
        'currency' => 'currency',
        'marketplaceList' => 'marketplaceList',
        'supportedLanguages' => 'supportedLanguages',
        'displayName' => 'displayName',
        'website' => 'website',
        'supportContact' => 'supportContact',
        'vendor' => 'vendor',
        'signUpUrl' => 'signUpUrl',
        'updateUrl' => 'updateUrl',
        'featureList' => 'featureList'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'visibility' => 'setVisibility',
        'currency' => 'setCurrency',
        'marketplaceList' => 'setMarketplaceList',
        'supportedLanguages' => 'setSupportedLanguages',
        'displayName' => 'setDisplayName',
        'website' => 'setWebsite',
        'supportContact' => 'setSupportContact',
        'vendor' => 'setVendor',
        'signUpUrl' => 'setSignUpUrl',
        'updateUrl' => 'setUpdateUrl',
        'featureList' => 'setFeatureList'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'visibility' => 'getVisibility',
        'currency' => 'getCurrency',
        'marketplaceList' => 'getMarketplaceList',
        'supportedLanguages' => 'getSupportedLanguages',
        'displayName' => 'getDisplayName',
        'website' => 'getWebsite',
        'supportContact' => 'getSupportContact',
        'vendor' => 'getVendor',
        'signUpUrl' => 'getSignUpUrl',
        'updateUrl' => 'getUpdateUrl',
        'featureList' => 'getFeatureList'
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

    const VISIBILITY_JTL = 'JTL';
    const VISIBILITY_THIRDPARTY = 'THIRDPARTY';
    const VISIBILITY_ONBOARDING = 'ONBOARDING';
    const VISIBILITY_RESTRICTED = 'RESTRICTED';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getVisibilityAllowableValues()
    {
        return [
            self::VISIBILITY_JTL,
            self::VISIBILITY_THIRDPARTY,
            self::VISIBILITY_ONBOARDING,
            self::VISIBILITY_RESTRICTED,
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
        $this->container['visibility'] = $data['visibility'] ?? null;
        $this->container['currency'] = $data['currency'] ?? null;
        $this->container['marketplaceList'] = $data['marketplaceList'] ?? null;
        $this->container['supportedLanguages'] = $data['supportedLanguages'] ?? null;
        $this->container['displayName'] = $data['displayName'] ?? null;
        $this->container['website'] = $data['website'] ?? null;
        $this->container['supportContact'] = $data['supportContact'] ?? null;
        $this->container['vendor'] = $data['vendor'] ?? null;
        $this->container['signUpUrl'] = $data['signUpUrl'] ?? null;
        $this->container['updateUrl'] = $data['updateUrl'] ?? null;
        $this->container['featureList'] = $data['featureList'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     * @codeCoverageIgnore
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getVisibilityAllowableValues();
        if (!is_null($this->container['visibility']) && !in_array($this->container['visibility'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value '%s' for 'visibility', must be one of '%s'",
                $this->container['visibility'],
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['marketplaceList'] === null) {
            $invalidProperties[] = "'marketplaceList' can't be null";
        }
        if ($this->container['displayName'] === null) {
            $invalidProperties[] = "'displayName' can't be null";
        }
        if ($this->container['website'] === null) {
            $invalidProperties[] = "'website' can't be null";
        }
        if ($this->container['supportContact'] === null) {
            $invalidProperties[] = "'supportContact' can't be null";
        }
        if ($this->container['vendor'] === null) {
            $invalidProperties[] = "'vendor' can't be null";
        }
        if ($this->container['signUpUrl'] === null) {
            $invalidProperties[] = "'signUpUrl' can't be null";
        }
        if ($this->container['featureList'] === null) {
            $invalidProperties[] = "'featureList' can't be null";
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


    public function getVisibility(): ?string
    {
        return $this->container['visibility'];
    }

    public function setVisibility(?string $visibility): SalesChannelBase
    {
        $this->container['visibility'] = $visibility;
        return $this;
    }


    public function getCurrency(): ?string
    {
        return $this->container['currency'];
    }

    public function setCurrency(?string $currency): SalesChannelBase
    {
        $this->container['currency'] = $currency;
        return $this;
    }


    public function getMarketplaceList(): array
    {
        return $this->container['marketplaceList'];
    }

    public function setMarketplaceList(array $marketplaceList): SalesChannelBase
    {
        $this->container['marketplaceList'] = $marketplaceList;
        return $this;
    }


    public function getSupportedLanguages(): ?array
    {
        return $this->container['supportedLanguages'];
    }

    public function setSupportedLanguages(?array $supportedLanguages): SalesChannelBase
    {
        $this->container['supportedLanguages'] = $supportedLanguages;
        return $this;
    }


    public function getDisplayName(): string
    {
        return $this->container['displayName'];
    }

    public function setDisplayName(string $displayName): SalesChannelBase
    {
        $this->container['displayName'] = $displayName;
        return $this;
    }


    public function getWebsite(): string
    {
        return $this->container['website'];
    }

    public function setWebsite(string $website): SalesChannelBase
    {
        $this->container['website'] = $website;
        return $this;
    }


    public function getSupportContact(): string
    {
        return $this->container['supportContact'];
    }

    public function setSupportContact(string $supportContact): SalesChannelBase
    {
        $this->container['supportContact'] = $supportContact;
        return $this;
    }


    public function getVendor(): string
    {
        return $this->container['vendor'];
    }

    public function setVendor(string $vendor): SalesChannelBase
    {
        $this->container['vendor'] = $vendor;
        return $this;
    }


    public function getSignUpUrl(): string
    {
        return $this->container['signUpUrl'];
    }

    public function setSignUpUrl(string $signUpUrl): SalesChannelBase
    {
        $this->container['signUpUrl'] = $signUpUrl;
        return $this;
    }


    public function getUpdateUrl(): ?string
    {
        return $this->container['updateUrl'];
    }

    public function setUpdateUrl(?string $updateUrl): SalesChannelBase
    {
        $this->container['updateUrl'] = $updateUrl;
        return $this;
    }


    public function getFeatureList(): ChannelUpdateFeatureList
    {
        return $this->container['featureList'];
    }

    public function setFeatureList(ChannelUpdateFeatureList $featureList): SalesChannelBase
    {
        $this->container['featureList'] = $featureList;
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
