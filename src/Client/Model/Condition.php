<?php
/**
 * Condition
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

use JTL\SCX\Lib\Channel\Client\EnumInterface;

/**
 * Condition Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class Condition implements EnumInterface
{
    private $value;

    /**
     * Possible values of this enum
     */
    public const ORIGINAL_PACKAGING = 'ORIGINAL_PACKAGING';
    public const MINT_CONDITION = 'MINT_CONDITION';
    public const SLIGHTLY_USED = 'SLIGHTLY_USED';
    public const HEAVILY_USED = 'HEAVILY_USED';
    public const DAMAGED = 'DAMAGED';
    public const INCOMPLETE_DELIVERY = 'INCOMPLETE_DELIVERY';
    public const FRAUD = 'FRAUD';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::ORIGINAL_PACKAGING,
            self::MINT_CONDITION,
            self::SLIGHTLY_USED,
            self::HEAVILY_USED,
            self::DAMAGED,
            self::INCOMPLETE_DELIVERY,
            self::FRAUD,
        ];
    }


    public static function ORIGINAL_PACKAGING(): Condition
    {
        return new self('ORIGINAL_PACKAGING');
    }

    public static function MINT_CONDITION(): Condition
    {
        return new self('MINT_CONDITION');
    }

    public static function SLIGHTLY_USED(): Condition
    {
        return new self('SLIGHTLY_USED');
    }

    public static function HEAVILY_USED(): Condition
    {
        return new self('HEAVILY_USED');
    }

    public static function DAMAGED(): Condition
    {
        return new self('DAMAGED');
    }

    public static function INCOMPLETE_DELIVERY(): Condition
    {
        return new self('INCOMPLETE_DELIVERY');
    }

    public static function FRAUD(): Condition
    {
        return new self('FRAUD');
    }


    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
