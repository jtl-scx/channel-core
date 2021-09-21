<?php

namespace JTL\SCX\Lib\Channel\Core;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\PhpUsleep
 */
class PhpUsleepTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_sleep(): void
    {
        $sut = new PhpUsleep();

        $wait = 0.05;
        $start = microtime(true);
        $sut->sleep($wait);
        $now = microtime(true);

        self::assertGreaterThanOrEqual($start + $wait, $now);
    }
}
