<?php declare(strict_types=1);

use JTL\SCX\Lib\Channel\Core\Lock\MongoDbLockProvider;
use JTL\SCX\Lib\Channel\Database\Migration\AbstractCollectionSchema;
use MongoDB\Collection;

/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */
class LockSchema extends AbstractCollectionSchema
{

    public function getCollectionName(): string
    {
        return MongoDbLockProvider::COLLECTION_NAME;
    }

    public function getCollectionOption(): array
    {
        return [];
    }

    public function ensureSchema(Collection $collection): void
    {
        $collection->createIndex(
            ['lockKey' => 1],
            ['name' => 'unq__lockKey', 'unique' => true]
        );
        $collection->createIndex(
            ['expireAt' => 1],
            ['name' => 'ttl__expiresAt', 'expireAfterSeconds' => 0]
        );
    }
}