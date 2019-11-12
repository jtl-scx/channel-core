<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-08
 */

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\MetaData\CategoryList;

interface MetaCategoryLoader
{
    public function fetchAll(): CategoryList;
}
