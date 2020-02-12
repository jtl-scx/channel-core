<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/12/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextualInstance;
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

    public function emergency($message, array $context = [])
    {
        $this->log(Logger::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->log(Logger::ALERT, $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log(Logger::CRITICAL, $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log(Logger::ERROR, $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log(Logger::WARNING, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->log(Logger::NOTICE, $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log(Logger::INFO, $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->log(Logger::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    public function enableStdoutSteam(): void
    {
        if ($this->stdoutEnabled === false) {
            $this->logger->pushHandler(new StreamHandler("php://stdout"));
            $this->stdoutEnabled = true;
        }
    }

    public function replaceContext(ContextualInstance $contextualInstance): void
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
            ["JTL\\SCX\\Lib\\Channel\\Core\\Log"]
        );
        $this->logger->pushProcessor($introspectionProcessor);
        $this->logger->pushProcessor(new MemoryUsageProcessor());
        $this->logger->pushProcessor(new ProcessIdProcessor());
        $this->logger->pushProcessor(new UidProcessor());
    }

    private function removeProcessorsFromLogger(): void
    {
        foreach ($this->logger->getProcessors() as $processor) {
            $this->logger->popProcessor();
        }
    }
}
