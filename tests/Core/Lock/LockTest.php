<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */

namespace Core\Lock;

use JTL\SCX\Lib\Channel\Contract\Core\Lock\LockProvider;
use JTL\SCX\Lib\Channel\Core\Lock\Lock;
use MongoDB\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Lock\Lock
 */
class LockTest extends TestCase
{

    public function testCanObtain(): void
    {
        $now = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('obtain')
            ->with($lockKey, self::callback(function (\DateTimeImmutable $expiresAt) use ($now, $ttl) {
                return $now->getTimestamp() + $ttl === $expiresAt->getTimestamp();
            }))->willReturn(true);
        $lock = new Lock($lockProvider, $lockKey, $ttl);
        self::assertTrue($lock->obtain($now));
    }

    public function testObtainWillFail(): void
    {
        $now = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('obtain')
            ->with($lockKey, self::callback(function (\DateTimeImmutable $expiresAt) use ($now, $ttl) {
                return $now->getTimestamp() + $ttl === $expiresAt->getTimestamp();
            }))->willReturn(false);
        $lock = new Lock($lockProvider, $lockKey, $ttl);
        self::assertFalse($lock->obtain($now));
    }

    public function testCanExtend(): void
    {
        $now = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('extend')
            ->with($lockKey, self::callback(function (\DateTimeImmutable $expiresAt) use ($now, $ttl) {
                return $now->getTimestamp() + $ttl === $expiresAt->getTimestamp();
            }))->willReturn(true);
        $lock = new Lock($lockProvider, $lockKey, random_int(1, 99));
        self::assertTrue($lock->extend($ttl, $now));
    }

    public function testExtendWillFail(): void
    {
        $now = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('extend')
            ->with($lockKey, self::callback(function (\DateTimeImmutable $expiresAt) use ($now, $ttl) {
                return $now->getTimestamp() + $ttl === $expiresAt->getTimestamp();
            }))->willReturn(false);
        $lock = new Lock($lockProvider, $lockKey, random_int(1, 99));
        self::assertFalse($lock->extend($ttl, $now));
    }

    public function testCanCheckIsLocked(): void
    {
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('isset')->with($lockKey)->willReturn(true);
        $lock = new Lock($lockProvider, $lockKey, $ttl);
        self::assertTrue($lock->isLocked());
    }

    public function testCanCheckIsNotLocked(): void
    {
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('isset')->with($lockKey)->willReturn(false);
        $lock = new Lock($lockProvider, $lockKey, $ttl);
        self::assertFalse($lock->isLocked());
    }

    public function testCanUnlock(): void
    {
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('delete')->with($lockKey)->willReturn(true);
        $lock = new Lock($lockProvider, $lockKey, $ttl, false);
        self::assertTrue($lock->unlock());
    }

    public function testCanUnlockWillFail(): void
    {
        $lockKey = uniqid('lockKey', true);
        $ttl = random_int(1, 99);
        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('delete')->with($lockKey)->willReturn(false);
        $lock = new Lock($lockProvider, $lockKey, $ttl, false);
        self::assertFalse($lock->unlock());
    }
}
