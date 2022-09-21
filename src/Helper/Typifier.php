<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-27
 */

namespace JTL\SCX\Lib\Channel\Helper;

/**
 * Class Typifier
 * @package JTL\SCX\Lib\Channel\Helper
 *
 * @method ?int toIntOrNull($value)
 * @method ?string toStringOrNull($value)
 */
class Typifier
{
    public static function toIntOrNull($value): ?int
    {
        return isset($value) ? (int)$value : null;
    }

    public static function toStringOrNull($value): ?string
    {
        return isset($value) ? (string)$value : null;
    }

    public static function toBoolOrNull($value): ?bool
    {
        return isset($value) ? (bool)$value : null;
    }

    public static function toArrayOrNull($value): ?array
    {
        return isset($value) ? (array)$value : null;
    }

    public static function toDateTimeOrNull(?string $value): ?\DateTime
    {
        try {
            return new \DateTime($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function toDateTimeImmutableOrNull(?string $value): ?\DateTimeImmutable
    {
        try {
            return new \DateTimeImmutable($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
