<?php

namespace JTL\SCX\Lib\Channel\Helper;

use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Helper\Clock
 */
class ClockTest extends TestCase
{
    public function testCanGetNowDateTime(): void
    {
        $beginTime = new \DateTimeImmutable();
        $sut = new Clock();

        $now = $sut->now();
        self::assertTrue($beginTime < $now);
        self::assertTrue(new \DateTimeImmutable() > $now);
    }
}
