<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Contract\Core\Lock\LockProvider;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\Collection;
use MongoDB\Driver\Exception\RuntimeException;

class MongoDbLockProvider implements LockProvider
{
    public const COLLECTION_NAME = 'lock';

    private Collection $collection;
    private UTCDateTimeConverter $dateTimeConverter;

    public function __construct(MongoDbConnection $connection, UTCDateTimeConverter $dateTimeConverter)
    {
        $this->collection = $connection->selectCollection(self::COLLECTION_NAME);
        $this->dateTimeConverter = $dateTimeConverter;
    }

    public function delete(string $key): bool
    {
        $result = $this->collection->deleteMany([
            "lockKey" => $key,
        ]);

        return $result->getDeletedCount() > 0;
    }

    public function obtain(string $key, \DateTimeImmutable $expireAt): bool
    {
        try {
            $result = $this->collection->insertOne([
                "lockKey" => $key,
                "expireAt" => $this->dateTimeConverter->create($expireAt),
            ]);
        } catch (RuntimeException $e) {
            return false;
        }

        return $result->getInsertedCount() > 0;
    }

    public function extend(string $key, \DateTimeImmutable $expireAt): bool
    {
        try {
            $result = $this->collection->updateOne(
                ["lockKey" => $key],
                [
                    '$set' => [
                        "expireAt" => $this->dateTimeConverter->create($expireAt),
                    ],
                    '$setOnInsert' => [
                        "lockKey" => $key,
                    ],
                ],
                ['upsert' => true]
            );
        } catch (RuntimeException $exception) {
            return false;
        }

        return $result->isAcknowledged();
    }

    public function isset(string $key): bool
    {
        $result = $this->collection->findOne([
            "lockKey" => $key,
        ]);

        return $result !== null;
    }
}
