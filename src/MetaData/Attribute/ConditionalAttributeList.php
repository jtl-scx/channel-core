<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\Generic\GenericCollection;

/**
 * Class ConditionalAttributeList
 * @package JTL\SCX\Lib\Channel\MetaData\Attribute
 * @method ConditionalAttribute offsetGet($offset)
 */
class ConditionalAttributeList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(ConditionalAttribute::class);
    }
}
