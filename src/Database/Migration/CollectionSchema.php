<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/16/20
 */

namespace JTL\SCX\Lib\Channel\Database\Migration;

use MongoDB\Collection;

#[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
interface CollectionSchema
{
    public function getCollectionName(): string;

    public function getCollectionOption(): array;

    public function ensureSchema(Collection $collection): void;
}
