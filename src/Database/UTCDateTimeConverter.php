<?php

declare(strict_types=1);
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
    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function create(?\DateTimeInterface $dateTime): ?UTCDateTime
    {
        if ($dateTime instanceof \DateTimeInterface) {
            return new UTCDateTime($dateTime);
        }
        return null;
    }


    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function convert(?UTCDateTime $utcDateTime): ?\DateTimeImmutable
    {
        if ($utcDateTime instanceof UTCDateTime) {
            return new \DateTimeImmutable($utcDateTime->toDateTime()->format(\DateTimeInterface::RFC3339_EXTENDED));
        }
        return null;
    }


    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function now(): UTCDateTime
    {
        return new UTCDateTime();
    }
}
