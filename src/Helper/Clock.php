<?php

namespace JTL\SCX\Lib\Channel\Helper;

use Psr\Clock\ClockInterface;

class Clock implements ClockInterface
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
