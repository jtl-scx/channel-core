<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use Exception;
use JTL\SCX\Lib\Channel\Contract\Core\Log\LogFactory;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologFactory implements LogFactory
{
    /**
     * Values that enable stdout logging. We use an explicit whitelist instead of
     * Environment::getBool() on purpose: (bool)"false" evaluates to true, which would
     * make LOG_STDOUT=false accidentally enable stdout logging.
     */
    private const STDOUT_ENABLED_VALUES = ['1', 'true', 'on', 'yes'];

    public function __construct(private readonly Environment $environment)
    {
    }

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

        $handler = $this->createHandler($globalLogLevel, $logFile);
        $handler->setFormatter(new JsonFormatter());

        $monolog->pushHandler($handler);
        return $monolog;
    }

    /**
     * Selects exactly one handler: when LOG_STDOUT is enabled logs are written as JSON to
     * php://stdout, otherwise logs are written to the
     * rotating file as before. The file is NOT written additionally when stdout is enabled.
     */
    private function createHandler(int $globalLogLevel, string $logFile): StreamHandler
    {
        if ($this->isStdoutEnabled()) {
            return new StreamHandler('php://stdout', $globalLogLevel);
        }

        $retentionDays = (int)($this->environment->get('LOG_RETENTION_DAYS') ?? 3);
        return new RotatingFileHandler($logFile, $retentionDays, $globalLogLevel);
    }

    private function isStdoutEnabled(): bool
    {
        $value = $this->environment->get('LOG_STDOUT');
        if ($value === null) {
            return false;
        }

        return in_array(strtolower(trim((string)$value)), self::STDOUT_ENABLED_VALUES, true);
    }
}
