<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */

namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Contract\Core\Lock\LockProvider;

class Lock
{
    private LockProvider $lockProvider;
    private string $key;
    private int $ttl;
    private bool $unlockOnDestruct;

    public function __construct(LockProvider $lockProvider, string $key, int $ttl = 0, bool $unlockOnDestruct = true)
    {
        $this->lockProvider = $lockProvider;
        $this->key = $key;
        $this->ttl = $ttl;
        $this->unlockOnDestruct = $unlockOnDestruct;
    }

    public function __destruct()
    {
        if ($this->unlockOnDestruct === true) {
            $this->unlock();
        }
    }

    public function unlock(): bool
    {
        return $this->lockProvider->delete($this->key);
    }


    public function obtain(\DateTimeImmutable $now = null): bool
    {
        if ($now === null) {
            $now = new \DateTimeImmutable();
        }
        $this->isLocked = $this->lockProvider->obtain($this->key, $now->add(new \DateInterval("PT{$this->ttl}S")));
        return $this->isLocked;
    }

    public function extend(int $ttl = null, \DateTimeImmutable $now = null): bool
    {
        if ($ttl === null) {
            $ttl = $this->ttl;
        }

        if ($now === null) {
            $now = new \DateTimeImmutable();
        }

        $this->isLocked = $this->lockProvider->extend($this->key, $now->add(new \DateInterval("PT{$ttl}S")));
        return $this->isLocked;
    }

    public function isLocked(): bool
    {
        return $this->lockProvider->isset($this->key);

    }
}