<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Lock;

interface LockProvider
{
    public function delete(string $key): bool;

    public function obtain(string $key, \DateTimeImmutable $expiresAt): bool;

    public function extend(string $key, \DateTimeImmutable $expireAt): bool;

    public function isset(string $key): bool;
}
