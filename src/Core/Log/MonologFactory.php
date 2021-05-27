<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use Exception;
use JTL\SCX\Lib\Channel\Contract\Core\Log\LogFactory;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologFactory implements LogFactory
{
    /**
     * @param int $globalLogLevel
     * @param string $logFile
     * @param string $channel
     * @return LoggerInterface|Logger
     * @throws Exception
     */
    public function create(int $globalLogLevel, string $logFile, string $channel): LoggerInterface
    {
        $monolog = new Logger($channel);

        $streamHandler = new RotatingFileHandler($logFile, 7, $globalLogLevel);
        $streamHandler->setFormatter(new JsonFormatter());

        $monolog->pushHandler($streamHandler);
        return $monolog;
    }
}
