<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Client\Model\Attribute;
use MyCLabs\Enum\Enum;

/**
 * Class AttributeType
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @method static AttributeType SMALLTEXT()
 * @method static AttributeType HTMLTEXT()
 * @method static AttributeType TEXT()
 * @method static AttributeType INTEGER()
 * @method static AttributeType DECIMAL()
 * @method static AttributeType ENUM()
 * @method static AttributeType DATE()
 * @method static AttributeType BOOLEAN()
 */
class AttributeType extends Enum
{
    private const SMALLTEXT = Attribute::TYPE_SMALLTEXT;
    private const HTMLTEXT = Attribute::TYPE_HTMLTEXT;
    private const TEXT = Attribute::TYPE_TEXT;
    private const INTEGER = Attribute::TYPE_INTEGER;
    private const DECIMAL = Attribute::TYPE_DECIMAL;
    private const ENUM = Attribute::TYPE_ENUM;
    private const DATE = Attribute::TYPE_DATE;
    private const BOOLEAN = Attribute::TYPE_BOOLEAN;
}
