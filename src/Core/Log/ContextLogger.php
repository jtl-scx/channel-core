<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/12/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\UidProcessor;

class ContextLogger implements ScxLogger
{
    private Logger $logger;
    private bool $stdoutEnabled = false;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->setup();
    }

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::EMERGENCY, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::ALERT, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::CRITICAL, $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::ERROR, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::WARNING, $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::NOTICE, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::INFO, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(Logger::DEBUG, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }

    public function enableStdoutStream(): void
    {
        if ($this->stdoutEnabled === false) {
            $this->logger->pushHandler(new StreamHandler("php://stdout"));
            $this->stdoutEnabled = true;
        }
    }

    public function replaceContext(ContextAware $contextualInstance): void
    {
        $contextProcessor = $contextualInstance->createContextInstance();

        $existingProcessorList = $this->logger->getProcessors();
        $this->removeProcessorsFromLogger();

        foreach ($existingProcessorList as $existingProcessor) {
            if (!$contextProcessor instanceof $existingProcessor) {
                $this->logger->pushProcessor($existingProcessor);
            }
        }
        $this->logger->pushProcessor($contextProcessor);
    }

    public function reset(): void
    {
        $this->removeProcessorsFromLogger();
        $this->setup();
    }

    private function setup()
    {
        $introspectionProcessor = new IntrospectionProcessor(
            Logger::DEBUG,
            ["JTL\\SCX\\Lib\\Channel\\Core\\Log\\"]
        );
        $this->logger->pushProcessor($introspectionProcessor);
        $this->logger->pushProcessor(new MemoryUsageProcessor());
        $this->logger->pushProcessor(new ProcessIdProcessor());
        $this->logger->pushProcessor(new UidProcessor(10));
        $this->logger->pushProcessor(new RuntimeProcessor());
    }

    private function removeProcessorsFromLogger(): void
    {
        foreach ($this->logger->getProcessors() as $_) {
            $this->logger->popProcessor();
        }
    }
}
