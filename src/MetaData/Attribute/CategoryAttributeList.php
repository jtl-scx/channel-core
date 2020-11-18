<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-18
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\Generic\GenericCollection;

/**
 * @method CategoryAttribute offsetGet($offset)
 */
class CategoryAttributeList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(CategoryAttribute::class);
    }

    public function addAttributeList(string $categoryId, AttributeList $attibuteList)
    {
        parent::add(new CategoryAttribute($categoryId, $attibuteList));
    }
}
