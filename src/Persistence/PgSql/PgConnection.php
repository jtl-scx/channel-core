<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 10/2/19
 */

namespace JTL\SCX\Lib\Channel\Persistence\PgSql;

use JTL\SCX\Lib\Channel\Persistence\PgSql\Contract\IPgModel;

class PgConnection
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $db;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var resource
     */
    private $connection;

    public function __construct(string $host, string $db, string $user, string $password)
    {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect(): self
    {
        $connection = pg_connect("host={$this->host} dbname={$this->db} user={$this->user} password={$this->password} connect_timeout=5");

        if ($connection === false) {
            throw new \RuntimeException("oof");
        }

        $this->connection = $connection;
        return $this;
    }

    public function insert(string $table, IPgModel $model): self
    {
        $paramCounter = 1;
        $values = implode(
            ', ',
            array_map(static function ($value) use (&$paramCounter) {
                return '$' . $paramCounter++;
            }, $model->toArray())
        );
        $stmt = "INSERT INTO {$table} VALUES ({$values})";

        return $this->execute($stmt, array_values($model->toArray()));
    }

    public function update(string $table, IPgModel $model): self
    {
        $stmt = "UPDATE {$table} SET ";
        $values = $model->toArray();
        $setList = [];

        foreach ($values as $key => $value) {
            $setList[] = "$key=?";
        }

        $stmt .= implode(', ', $setList);

        return $this->execute($stmt, array_values($model->toArray()));
    }

    public function execute(string $statement, array $params): self
    {
        $result = pg_query_params($this->connection, $statement, $params);

        if ($result === false) {
            throw new \RuntimeException("oof");
        }

        pg_free_result($result);
        return $this;
    }
}
