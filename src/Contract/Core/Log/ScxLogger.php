<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/12/20
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Log;

use Psr\Log\LoggerInterface;

interface ScxLogger extends LoggerInterface
{
    public function reset(): void;

    public function enableStdoutSteam(): void;

    public function replaceContext(callable $contextProcessor): void;
}
