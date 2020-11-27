<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-27
 */

namespace JTL\SCX\Lib\Channel\Helper;

class Typifier
{
    public function toIntOrNull($value): ?int
    {
        return isset($value) ? (int)$value : null;
    }

    public function toStringOrNull($value): ?string
    {
        return isset($value) ? (string)$value : null;
    }

    public function toBoolOrNull($value): ?bool
    {
        return isset($value) ? (bool)$value : null;
    }

    public function toArrayOrNull($value): ?array
    {
        return isset($value) ? (array)$value : null;
    }

    public function toDateTimeOrNull(?string $value): ?\DateTime
    {
        try {
            return new \DateTime($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function toDateTimeImmutableOrNull(?string $value): ?\DateTimeImmutable
    {
        try {
            return new \DateTimeImmutable($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}