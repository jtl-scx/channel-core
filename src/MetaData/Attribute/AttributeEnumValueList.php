<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-10
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use InvalidArgumentException;
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

    public static function fromArray(?array $array): self
    {
        $list = new self();
        if ($array === null) {
            return $list;
        }

        foreach ($array as $value) {
            if (!isset($value['value'])) {
                throw new InvalidArgumentException(
                    'There must be at a array key "value"'
                );
            }

            $display = null;
            if (isset($value['display'])) {
                $display = (string)$value['display'];
            }

            $list->add(new AttributeEnumValue((string)$value['value'], $display));
        }
        return $list;
    }

    public static function fromScalarArray(?array $valueList): ?self
    {
        if ($valueList === null) {
            return null;
        }

        $list = new self();
        foreach ($valueList as $value) {
            if (!is_scalar($value)) {
                throw new InvalidArgumentException(
                    'AttributeEnumValueList can only be created from a array of scalar values'
                );
            }
            $list->add(new AttributeEnumValue((string)$value));
        }
        return $list;
    }
}
