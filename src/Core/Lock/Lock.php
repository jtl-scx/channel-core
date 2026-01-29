<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */

namespace JTL\SCX\Lib\Channel\Core\Lock;

class Lock
{
    private string $key;
    private \DateTimeImmutable $expiresAt;

    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function __construct(string $key, \DateTimeImmutable $expiresAt)
    {
        $this->key = $key;
        $this->expiresAt = $expiresAt;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }
}
