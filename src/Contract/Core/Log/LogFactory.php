<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Log;

use Psr\Log\LoggerInterface;

interface LogFactory
{
    public function create(int $globalLogLevel, string $logFile, string $channel): LoggerInterface;
}
