<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/16/20
 */

namespace JTL\SCX\Lib\Channel\Database\Migration;

use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;

class SchemaUpdater
{
    private MongoDbConnection $dbConn;


    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function __construct(MongoDbConnection $mongoDbClient)
    {
        $this->dbConn = $mongoDbClient;
    }

    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function runMigration(CollectionSchema $collectionSchema, string $dbName): array
    {
        $database = $this->dbConn->getClient()->selectDatabase($dbName);

        $collection = $this->selectOrCreateCollection($collectionSchema, $database);
        $collectionSchema->ensureSchema($collection);

        $idxInfo = [];
        foreach ($database->selectCollection($collectionSchema->getCollectionName())->listIndexes() as $idx) {
            $idxInfo[] = $idx->__debugInfo();
        }
        return $idxInfo;
    }

    /**
     * @param CollectionSchema $collectionSchema
     * @param Database $database
     * @return Collection
     */
    private function selectOrCreateCollection(CollectionSchema $collectionSchema, Database $database): Collection
    {
        $existingCollection = null;
        foreach ($database->listCollections() as $collection) {
            if ($collection->getName() === $collectionSchema->getCollectionName()) {
                $existingCollection = $database->selectCollection($collectionSchema->getCollectionName());
            }
        }

        if ($existingCollection === null) {
            $database->createCollection(
                $collectionSchema->getCollectionName(),
                $collectionSchema->getCollectionOption()
            );

            $existingCollection = $database->selectCollection($collectionSchema->getCollectionName());
        }
        return $existingCollection;
    }
}
