<?php declare(strict_types=1);


namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Contract\Core\Lock\LockProvider;

class DefaultLockProvider implements LockProvider
{
    public function delete(string $key): bool
    {
        return true;
    }

    public function obtain(string $key, \DateTimeImmutable $expiresAt): bool
    {
        return true;
    }

    public function extend(string $key, \DateTimeImmutable $expireAt): bool
    {
        return true;
    }

    public function isset(string $key): bool
    {
        return false;
    }
}
