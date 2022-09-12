<?php
/**
 * InvoiceDocumentType
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
 * InvoiceDocumentType Class Doc Comment
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class InvoiceDocumentType implements EnumInterface
{
    private $value;

    /**
     * Possible values of this enum
     */
    const INVOICE = 'INVOICE';
    const CREDITNOTE = 'CREDITNOTE';
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::INVOICE,
            self::CREDITNOTE,
        ];
    }

    
    public static function INVOICE(): InvoiceDocumentType
    {
        return new self('INVOICE');
    }
    
    public static function CREDITNOTE(): InvoiceDocumentType
    {
        return new self('CREDITNOTE');
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
