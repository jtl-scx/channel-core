<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\Generic\GenericCollection;

/**
 * Class CategoryAttributeList
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 *
 * @method CategoryAttribute offsetGet()
 */
class CategoryAttributeList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(CategoryAttribute::class);
    }
}
