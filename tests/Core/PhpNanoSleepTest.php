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

        $start = microtime(true);
        $sut->sleep(0.1);
        $sut->sleep(0.9);
        $sut->sleep(1.1);
        $now = microtime(true);

        self::assertTrue($now - $start > 2.0, "Expect to sleep at least 2 seconds but slept only " . ($now - $start) . " seconds");
    }
}
