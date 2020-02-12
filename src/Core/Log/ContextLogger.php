<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/12/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\UidProcessor;

/**
 * Class ContextLogger
 * @method void log($message, array $context = array())
 * @method void debug($message, array $context = array())
 * @method void info($message, array $context = array())
 * @method void notice($message, array $context = array())
 * @method void warning($message, array $context = array())
 * @method void error($message, array $context = array())
 * @method void critical($message, array $context = array())
 * @method void alert($message, array $context = array())
 * @method void emergency($message, array $context = array())
 */
class ContextLogger
{
    private Logger $logger;
    private bool $stdoutEnabled = false;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->setup();
    }

    public function __call($name, $arguments)
    {
        $this->logger->{$name}(...$arguments);
    }

    public function enableStdoutSteam()
    {
        if ($this->stdoutEnabled === false) {
            $this->logger->pushHandler(new StreamHandler("php://stdout"));
            $this->stdoutEnabled = true;
        }
    }

    public function reset()
    {
        $this->removeProcessorsFromLogger();
        $this->setup();
    }

    protected function replaceProcessor(object $newProcessor)
    {
        $existingProcessorList = $this->logger->getProcessors();
        $this->removeProcessorsFromLogger();

        foreach ($existingProcessorList as $existingProcessor) {
            if (!$newProcessor instanceof $existingProcessor) {
                $this->logger->pushProcessor($existingProcessor);
            }
        }
        $this->logger->pushProcessor($newProcessor);
    }

    private function setup()
    {
        $this->logger->pushProcessor(new IntrospectionProcessor());
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
