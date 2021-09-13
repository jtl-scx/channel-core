<?php

namespace JTL\SCX\Lib\Channel\Database;

use MongoDB\BSON\UTCDateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter
 */
class UTCDateTimeConverterTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_time_now(): void
    {
        $sut = new UTCDateTimeConverter();
        self::assertInstanceOf(UTCDateTime::class, $sut->now());
    }
}
