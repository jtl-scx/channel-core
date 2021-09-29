<?php

namespace JTL\SCX\Lib\Channel\Core;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\PhpNanoSleep
 */
class PhpNanoSleepTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_sleep(): void
    {
        $sut = new PhpNanoSleep();

        $wait = 0.13089;
        $start = microtime(true);
        $sut->sleep($wait);
        $now = microtime(true);

        self::assertGreaterThanOrEqual($now, $start + $wait);
    }
}
