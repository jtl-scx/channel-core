<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-27
 */

namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Core\Lock\Lock;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Lock\Lock
 */
class LockTest extends TestCase
{
    public function testGetExpiresAt()
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        self::assertSame($expiresAt, $lock->getExpiresAt());
    }

    public function testGetKey()
    {
        $expiresAt = new \DateTimeImmutable();
        $lockKey = uniqid('lockKey', true);
        $lock = new Lock($lockKey, $expiresAt);

        self::assertSame($lockKey, $lock->getKey());
    }
}
