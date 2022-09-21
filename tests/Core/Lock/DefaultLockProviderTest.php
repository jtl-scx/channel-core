<?php

declare(strict_types=1);

namespace Core\Lock;

use JTL\SCX\Lib\Channel\Core\Lock\DefaultLockProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultLockProviderTest
 * @package Core\Lock
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Lock\DefaultLockProvider
 */
class DefaultLockProviderTest extends TestCase
{
    public function testCanReturnDefaultValues(): void
    {
        $lockProvider = new DefaultLockProvider();

        $this->assertTrue($lockProvider->delete('foo'));
        $this->assertTrue($lockProvider->obtain('foo', new \DateTimeImmutable()));
        $this->assertTrue($lockProvider->extend('foo', new \DateTimeImmutable()));
        $this->assertFalse($lockProvider->isset('foo'));
    }
}
