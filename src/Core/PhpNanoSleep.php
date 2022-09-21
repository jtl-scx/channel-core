<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core;

use JTL\SCX\Lib\Channel\Contract\Core\Sleeper;

final class PhpNanoSleep implements Sleeper
{
    public function sleep(float $seconds): void
    {
        $fullSec = (int)floor($seconds);
        $decimalPlaces = $seconds - $fullSec;
        $nano = (int)($decimalPlaces * 1000000);
        time_nanosleep($fullSec, $nano);
    }
}
