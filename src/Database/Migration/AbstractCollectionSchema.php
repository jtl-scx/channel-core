<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 7/22/20
 */

namespace JTL\SCX\Lib\Channel\Database\Migration;

use MongoDB\Collection;

abstract class AbstractCollectionSchema implements CollectionSchema
{
    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    protected function dropIndexIfExists(Collection $collection, string $indexName): void
    {
        foreach ($collection->listIndexes() as $info) {
            if ($info->getName() === $indexName) {
                $collection->dropIndex($indexName);
                return;
            }
        }
    }
}
