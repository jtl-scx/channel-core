<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-27
 */

namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Contract\Core\Lock\LockProvider;

class LockFactory
{
    private LockProvider $lockProvider;
    /**
     * @var array<Lock>
     */
    private array $unlockOnDestructList = [];

    public function __construct(LockProvider $lockProvider)
    {
        $this->lockProvider = $lockProvider;
    }

    public function createLock(string $lockKey, int $ttl): Lock
    {
        return new Lock($lockKey, new \DateTimeImmutable("+ {$ttl} Seconds"));
    }

    public function __destruct()
    {
        foreach ($this->unlockOnDestructList as $lock) {
            $this->unlock($lock);
        }
    }

    public function unlock(Lock $lock): bool
    {
        return $this->lockProvider->delete($lock->getKey());
    }

    public function obtain(Lock $lock, bool $unlockOnDestruct = false): bool
    {
        $isLocked = $this->lockProvider->obtain($lock->getKey(), $lock->getExpiresAt());

        if ($isLocked === true && $unlockOnDestruct === true) {
            $this->unlockOnDestructList[] = $lock;
        }

        return $isLocked;
    }

    public function extend(Lock $lock, \DateTimeImmutable $expiresAt = null): bool
    {
        $expiresAt = $expiresAt ?? $lock->getExpiresAt();
        return $this->lockProvider->extend($lock->getKey(), $expiresAt);
    }

    public function isLocked(Lock $lock): bool
    {
        return $this->lockProvider->isset($lock->getKey());
    }
}
