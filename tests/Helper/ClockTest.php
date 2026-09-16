<?php

namespace JTL\SCX\Lib\Channel\Helper;

use PHPUnit\Framework\Attributes\CoversClass;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Helper\Clock::class)]
class ClockTest extends TestCase
{
    public function testCanGetNowDateTime(): void
    {
        $beginTime = new DateTimeImmutable();
        $sut = new Clock();

        $now = $sut->now();
        self::assertTrue($beginTime < $now);
        self::assertTrue(new DateTimeImmutable() > $now);
    }
}
