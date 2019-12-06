<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataAttributeLoader;

class DefaultMetaDataAttributeLoader implements MetaDataAttributeLoader
{
    public function fetch(string $categoryId): ?CategoryAttributeList
    {
        die('Please implement JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataAttributeLoader and register your implementation via service.yaml');
    }
}
