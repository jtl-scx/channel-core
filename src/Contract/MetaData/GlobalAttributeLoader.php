<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/03
 */

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;

interface GlobalAttributeLoader
{
    public function load(): AttributeList;
}
