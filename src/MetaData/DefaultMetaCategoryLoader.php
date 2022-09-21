<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-08
 */

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
use RuntimeException;

class DefaultMetaCategoryLoader implements MetaCategoryLoader
{
    public function fetchAll(): CategoryList
    {
        throw new RuntimeException(
            'Please implement JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader and register your implementation via service.yaml'
        );
    }
}
