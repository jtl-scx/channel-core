<?php

namespace JTL\SCX\Lib\Channel\Helper;

class Clock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
