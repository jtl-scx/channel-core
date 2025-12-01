<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-09
 */

namespace JTL\SCX\Lib\Channel\Database;

use MongoDB\Client;
use MongoDB\Collection;


#[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
class MongoDbConnection
{
    private ?Client $dbConn = null;
    private DatabaseConnectionCredentials $databaseConnectionCredentials;


    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function __construct(DatabaseConnectionCredentials $databaseConnectionCredentials)
    {
        $this->databaseConnectionCredentials = $databaseConnectionCredentials;
    }

    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function selectCollection(string $collection): Collection
    {
        return $this->getDatabaseConnection()
            ->selectCollection($this->databaseConnectionCredentials->getDatabase(), $collection);
    }

    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function getClient(): Client
    {
        return $this->getDatabaseConnection();
    }

    private function getDatabaseConnection(): Client
    {
        if ($this->dbConn === null) {
            $option = [
                'readPreference' => 'secondaryPreferred',
            ];

            if (
                !empty($this->databaseConnectionCredentials->getUser())
                && !empty($this->databaseConnectionCredentials->getPassword())
            ) {
                $option['username'] = $this->databaseConnectionCredentials->getUser();
                $option['password'] = $this->databaseConnectionCredentials->getPassword();
            }
            $this->dbConn = new Client($this->databaseConnectionCredentials->getDsn(), $option);
        }

        return $this->dbConn;
    }
}
