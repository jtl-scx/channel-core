<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-09
 */

namespace JTL\SCX\Lib\Channel\Database;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDbConnection
{
    private ?Client $dbConn = null;
    private DatabaseConnectionCredentials $databaseConnectionCredentials;

    public function __construct(DatabaseConnectionCredentials $databaseConnectionCredentials)
    {
        $this->databaseConnectionCredentials = $databaseConnectionCredentials;
    }

    public function selectCollection(string $collection): Collection
    {
        return $this->getDatabaseConnection()
            ->selectCollection($this->databaseConnectionCredentials->getDatabase(), $collection);
    }

    public function getClient(): ?Client
    {
        return $this->getDatabaseConnection();
    }

    private function getDatabaseConnection(): Client
    {
        if ($this->dbConn === null) {
            $this->dbConn = new Client(
                $this->databaseConnectionCredentials->getDsn(),
                [
                    'username' => $this->databaseConnectionCredentials->getUser(),
                    'password' => $this->databaseConnectionCredentials->getPassword(),
                    'readPreference' => 'secondaryPreferred'
                ]
            );
        }
        return $this->dbConn;
    }
}
