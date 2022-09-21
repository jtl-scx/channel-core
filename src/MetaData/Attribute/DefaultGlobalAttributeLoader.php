<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/04
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\GlobalAttributeLoader;
use RuntimeException;

class DefaultGlobalAttributeLoader implements GlobalAttributeLoader
{
    public function load(): AttributeList
    {
        throw new RuntimeException('Please implement JTL\SCX\Lib\Channel\Contract\MetaData\GlobalAttributeLoader and register your implementation via service.yaml');
    }
}
