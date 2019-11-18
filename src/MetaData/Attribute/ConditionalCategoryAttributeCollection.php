<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\Generic\GenericCollection;

class ConditionalCategoryAttributeCollection extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(ConditionalCategoryAttribute::class);
    }
}
