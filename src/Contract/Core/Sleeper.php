<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Contract\Core;

interface Sleeper
{
    public function sleep(float $seconds): void;
}
