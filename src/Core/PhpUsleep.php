<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core;

use JTL\SCX\Lib\Channel\Contract\Core\Sleeper;

final class PhpUsleep implements Sleeper
{
    public function sleep(float $seconds): void
    {
        usleep((int)($seconds * 1000000));
    }
}
