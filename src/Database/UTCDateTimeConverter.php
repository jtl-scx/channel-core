<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-09
 */

namespace JTL\SCX\Lib\Channel\Database;

use MongoDB\BSON\UTCDateTime;

class UTCDateTimeConverter
{
    public function create(?\DateTimeInterface $dateTime): ?UTCDateTime
    {
        if ($dateTime instanceof \DateTimeInterface) {
            return new UTCDateTime($dateTime);
        }
        return null;
    }

    public function convert(?UTCDateTime $utcDateTime): ?\DateTimeImmutable
    {
        if ($utcDateTime instanceof UTCDateTime) {
            return new \DateTimeImmutable('@' . $utcDateTime->toDateTime()->getTimestamp());
        }
        return null;
    }
}