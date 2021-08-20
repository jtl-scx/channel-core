<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-27
 */

namespace JTL\SCX\Lib\Channel\Helper;

use JTL\SCX\Lib\Channel\Helper\Typifier;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Helper\Typifier
 */
class TypifierTest extends TestCase
{
    public function stringDataProvider(): array
    {
        return [
            ['test', 'test'],
            [null, null],
            [1234, '1234'],
            [true, '1'],
            [false, ''],
        ];
    }

    /**
     * @dataProvider stringDataProvider
     */
    public function testCanConvertToStringOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toStringOrNull($value));
    }

    public function intDataProvider(): array
    {
        return [
            ['test', 0],
            [null, null],
            [1234, 1234],
            [true, 1],
            [false, 0],
            [1, 1],
            [0, 0],
        ];
    }

    /**
     * @dataProvider intDataProvider
     */
    public function testCanConvertToIntOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toIntOrNull($value));
    }

    public function boolDataProvider(): array
    {
        return [
            ['test', true],
            [null, null],
            [1234, true],
            [true, true],
            [false, false],
            [1, true],
            [0, false],
            ['true', true],
            ['false', true],
        ];
    }

    /**
     * @dataProvider boolDataProvider
     */
    public function testCanConvertToBoolOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toBoolOrNull($value));
    }

    public function dateTimeDataProvider(): array
    {
        return [
            ['test', true],
            [null, true],
            ['yesterday', false],
            ['2020-02-02 20:20:20', false],
        ];
    }

    /**
     * @dataProvider dateTimeDataProvider
     */
    public function testCanConvertToDateTimeOrNull($value, $isNull): void
    {
        if ($isNull) {
            self::assertNull(Typifier::toDateTimeOrNull($value));
        } else {
            self::assertInstanceOf(\DateTime::class, Typifier::toDateTimeOrNull($value));
        }
    }

    /**
     * @dataProvider dateTimeDataProvider
     */
    public function testCanConvertToDateTimeImmutableOrNull($value, $isNull): void
    {
        if ($isNull) {
            self::assertNull(Typifier::toDateTimeImmutableOrNull($value));
        } else {
            self::assertInstanceOf(\DateTimeImmutable::class, Typifier::toDateTimeImmutableOrNull($value));
        }
    }

    public function arrayDataProvider(): array
    {
        $stdClass = new \stdClass();
        $stdClass->foo = 'bar';
        return [
            ['test', ['test']],
            [null, null],
            [true, [true]],
            [false, [false]],
            [1, [1]],
            [0, [0]],
            [['foo' => 'bar'], ['foo' => 'bar']],
            [$stdClass, ['foo' => 'bar']],
        ];
    }

    /**
     * @dataProvider arrayDataProvider
     */
    public function testCanConvertToArrayOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toArrayOrNull($value));
    }
}
