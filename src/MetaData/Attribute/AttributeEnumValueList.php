<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-10
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\Generic\GenericCollection;
use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

/**
 * @method AttributeEnumValue offsetGet($offset)
 */
class AttributeEnumValueList extends GenericCollection
{
    use ToArrayTrait;

    public function __construct()
    {
        parent::__construct(AttributeEnumValue::class);
    }

    public static function fromValueArray(?array $valueList): ?self
    {
        if ($valueList === null) {
            return null;
        }

        $list = new self();
        foreach ($valueList as $value) {
            if (!is_scalar($value)) {
                throw new \InvalidArgumentException(
                    'AttributeEnumValueList can only be created from a array of scalar values'
                );
            }
            $list->add(new AttributeEnumValue((string)$value));
        }
        return $list;
    }
}
