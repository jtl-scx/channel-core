<?php declare(strict_types=1);

use JTL\SCX\Lib\Channel\Client\Api\Auth\MongoDbSessionTokenRepository;
use JTL\SCX\Lib\Channel\Database\Migration\AbstractCollectionSchema;
use MongoDB\Collection;

class SessionTokenSchema extends AbstractCollectionSchema
{

    public function getCollectionName(): string
    {
        return MongoDbSessionTokenRepository::COLLECTION_NAME;
    }

    public function getCollectionOption(): array
    {
        return [];
    }

    public function ensureSchema(Collection $collection): void
    {
        $collection->createIndex(
            ['key' => 1],
            ['name' => 'unq__key', 'unique' => true]
        );
        $collection->createIndex(
            ['expireAt' => 1],
            ['name' => 'ttl__expiresAt', 'expireAfterSeconds' => 0]
        );
    }
}
