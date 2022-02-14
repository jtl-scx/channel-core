<?php
/**
 * RefundReason
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

use JTL\SCX\Lib\Channel\Client\EnumInterface;

/**
 * RefundReason Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class RefundReason implements EnumInterface
{
    private $value;

    /**
     * Possible values of this enum
     */
    const NO_REASON = 'NO_REASON';
    const DEFECT = 'DEFECT';
    const WRONG_ITEM = 'WRONG_ITEM';
    const WRONG_SIZE = 'WRONG_SIZE';
    const TOO_LATE = 'TOO_LATE';
    const BAD_QUALITY = 'BAD_QUALITY';
    const OTHER = 'OTHER';
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::NO_REASON,
            self::DEFECT,
            self::WRONG_ITEM,
            self::WRONG_SIZE,
            self::TOO_LATE,
            self::BAD_QUALITY,
            self::OTHER,
        ];
    }

    
    public static function NO_REASON(): RefundReason
    {
        return new self('NO_REASON');
    }
    
    public static function DEFECT(): RefundReason
    {
        return new self('DEFECT');
    }
    
    public static function WRONG_ITEM(): RefundReason
    {
        return new self('WRONG_ITEM');
    }
    
    public static function WRONG_SIZE(): RefundReason
    {
        return new self('WRONG_SIZE');
    }
    
    public static function TOO_LATE(): RefundReason
    {
        return new self('TOO_LATE');
    }
    
    public static function BAD_QUALITY(): RefundReason
    {
        return new self('BAD_QUALITY');
    }
    
    public static function OTHER(): RefundReason
    {
        return new self('OTHER');
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


