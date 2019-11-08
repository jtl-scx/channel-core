<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\MetaData;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;

/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-08
 */
class DefaultMetaCategoryLoader implements MetaCategoryLoader
{
    public function fetchAll(): CategoryList
    {
        die('Please implement JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader and register your implementation via service.yaml');
    }
}