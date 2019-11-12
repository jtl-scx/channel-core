<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class CategoryAttributeTypeMapper
{
    /**
     * @param string $type
     * @return string|null
     */
    public function map(string $type): ?string
    {
        switch ($type) {
            case 'Float':
                return 'decimal';
            case 'Bool':
                return 'boolean';
            case 'Int':
                return 'integer';
            case 'TinyText':
            case 'Ean':
                return 'smalltext';
            case 'Date':
                return 'date';
            case 'SmallText':
            case 'ShortText':
            case 'Text':
            case 'Picture':
            case preg_match('/^Si_[A-Za-z]+$/', $type) === 1:
                return 'text';
            default:
                return null;
        }
    }
}
