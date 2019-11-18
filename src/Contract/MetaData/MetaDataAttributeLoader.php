<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;

interface MetaDataAttributeLoader
{
    public function fetch(int $categoryId): ?CategoryAttributeList;
}
