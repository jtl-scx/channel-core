<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-28
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\Generic\GenericCollection;

/**
 * Class CategoryList
 * @method Category offsetGet()
 */
class CategoryList extends GenericCollection
{
    /**
     * CategoryList constructor.
     */
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}