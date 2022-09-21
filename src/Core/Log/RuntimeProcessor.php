<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use Monolog\Processor\ProcessorInterface;

class RuntimeProcessor implements ProcessorInterface
{
    private float $startTime;
    private float $lastLogTime;

    public function __construct(float $time = null)
    {
        $this->startTime = $time ?? microtime(true);
        $this->lastLogTime = $this->startTime;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $record)
    {
        $time = microtime(true);
        $record['runtime'] = $time - $this->startTime;
        $record['runtimeSinceLastLog'] = $time - $this->lastLogTime;
        $this->lastLogTime = $time;

        return $record;
    }
}
