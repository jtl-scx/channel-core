<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-09
 */

namespace JTL\SCX\Lib\Channel\Database;

class DatabaseConnectionCredentials
{
    private string $dsn;
    private string $user;
    private string $password;
    private string $database;

    public function __construct(string $dsn, string $user, string $password, string $database)
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }
}
