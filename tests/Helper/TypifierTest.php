<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-27
 */

namespace JTL\SCX\Lib\Channel\Helper;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use DateTime;
use DateTimeImmutable;
use stdClass;
use JTL\SCX\Lib\Channel\Helper\Typifier;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Helper\Typifier::class)]
class TypifierTest extends TestCase
{
    public static function stringDataProvider(): array
    {
        return [
            ['test', 'test'],
            [null, null],
            [1234, '1234'],
            [true, '1'],
            [false, ''],
        ];
    }

    #[DataProvider('stringDataProvider')]
    public function testCanConvertToStringOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toStringOrNull($value));
    }

    public static function intDataProvider(): array
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

    #[DataProvider('intDataProvider')]
    public function testCanConvertToIntOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toIntOrNull($value));
    }

    public static function boolDataProvider(): array
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

    #[DataProvider('boolDataProvider')]
    public function testCanConvertToBoolOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toBoolOrNull($value));
    }

    public static function dateTimeDataProvider(): array
    {
        return [
            ['test', true],
            [null, true],
            ['yesterday', false],
            ['2020-02-02 20:20:20', false],
        ];
    }

    #[DataProvider('dateTimeDataProvider')]
    public function testCanConvertToDateTimeOrNull($value, $isNull): void
    {
        if ($isNull) {
            self::assertNull(Typifier::toDateTimeOrNull($value));
        } else {
            self::assertInstanceOf(DateTime::class, Typifier::toDateTimeOrNull($value));
        }
    }

    #[DataProvider('dateTimeDataProvider')]
    public function testCanConvertToDateTimeImmutableOrNull($value, $isNull): void
    {
        if ($isNull) {
            self::assertNull(Typifier::toDateTimeImmutableOrNull($value));
        } else {
            self::assertInstanceOf(DateTimeImmutable::class, Typifier::toDateTimeImmutableOrNull($value));
        }
    }

    public static function arrayDataProvider(): array
    {
        $stdClass = new stdClass();
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

    #[DataProvider('arrayDataProvider')]
    public function testCanConvertToArrayOrNull($value, $expected): void
    {
        self::assertSame($expected, Typifier::toArrayOrNull($value));
    }
}
