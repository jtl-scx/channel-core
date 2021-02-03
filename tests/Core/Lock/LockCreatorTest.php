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
use JTL\SCX\Lib\Channel\Core\Lock\LockFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Lock\LockFactory
 */
class LockCreatorTest extends TestCase
{
    public function testCanCreateLock(): void
    {
        $lockKey = uniqid('lockKey', true);
        $lockProvider = $this->createStub(LockProvider::class);
        $lockFactory = new LockFactory($lockProvider);
        $lock = $lockFactory->createLock($lockKey, random_int(1, 99));

        self::assertInstanceOf(Lock::class, $lock);
        self::assertSame($lockKey, $lock->getKey());
    }

    public function testCanObtain(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('obtain')
            ->with($lockKey, $expiresAt)
            ->willReturn(true);
        $lockProvider->expects(self::never())->method('delete');
        $lockFactory = new LockFactory($lockProvider);
        self::assertTrue($lockFactory->obtain($lock));
    }

    public function testCanObtainAndUnlockAtDestruct(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('obtain')
            ->with($lockKey, $expiresAt)
            ->willReturn(true);
        $lockProvider->expects(self::once())->method('delete')
            ->with($lockKey)
            ->willReturn(true);
        $lockFactory = new LockFactory($lockProvider);
        self::assertTrue($lockFactory->obtain($lock, true));
        $lockFactory = null;
    }

    public function testObtainWillFail(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('obtain')
            ->with($lockKey, $expiresAt)
            ->willReturn(false);
        $lockFactory = new LockFactory($lockProvider);
        self::assertFalse($lockFactory->obtain($lock));
    }

    public function testCanExtend(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('extend')
            ->with($lockKey, $expiresAt)
            ->willReturn(true);
        $lockFactory = new LockFactory($lockProvider);
        self::assertTrue($lockFactory->extend($lock));
    }

    public function testExtendWillFail(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('extend')
            ->with($lockKey, $expiresAt)
            ->willReturn(false);
        $lockFactory = new LockFactory($lockProvider);
        self::assertFalse($lockFactory->extend($lock));
    }

    public function testCanCheckIsLocked(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('isset')->with($lockKey)->willReturn(true);
        $lockFactory = new LockFactory($lockProvider);
        self::assertTrue($lockFactory->isLocked($lock));
    }

    public function testCanCheckIsNotLocked(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('isset')->with($lockKey)->willReturn(false);
        $lockFactory = new LockFactory($lockProvider);
        self::assertFalse($lockFactory->isLocked($lock));
    }

    public function testCanUnlock(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('delete')->with($lockKey)->willReturn(true);
        $lockFactory = new LockFactory($lockProvider);
        self::assertTrue($lockFactory->unlock($lock));
    }

    public function testCanUnlockWillFail(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        $lockProvider = $this->createMock(LockProvider::class);
        $lockProvider->expects(self::once())->method('delete')->with($lockKey)->willReturn(false);
        $lockFactory = new LockFactory($lockProvider);
        self::assertFalse($lockFactory->unlock($lock));
    }
}
