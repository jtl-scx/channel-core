<?php

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\MonologFactory
 */
class MonologFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_create_a_log_instance(): void
    {
        $sut = new MonologFactory(self::createStub(Environment::class));
        $logger = $sut->create(101, '/tmp/foo', 'unittest');

        // check log-level
        self::assertTrue($logger->isHandling(101));

        $handlers = $logger->getHandlers();
        self::assertArrayHasKey(0, $handlers);
        self::assertInstanceOf(RotatingFileHandler::class, $handlers[0]);
    }

    /**
     * @test
     */
    public function it_uses_a_stdout_stream_handler_when_log_stdout_is_enabled(): void
    {
        $sut = new MonologFactory(new Environment(['LOG_STDOUT' => '1']));
        $logger = $sut->create(101, '/tmp/foo', 'unittest');

        $handlers = $logger->getHandlers();
        self::assertArrayHasKey(0, $handlers);
        self::assertInstanceOf(StreamHandler::class, $handlers[0]);
        // RotatingFileHandler extends StreamHandler, so guard against the extends trap.
        self::assertNotInstanceOf(RotatingFileHandler::class, $handlers[0]);
        self::assertInstanceOf(JsonFormatter::class, $handlers[0]->getFormatter());
    }

    /**
     * @test
     */
    public function it_uses_the_rotating_file_handler_when_log_stdout_is_the_string_false(): void
    {
        $sut = new MonologFactory(new Environment(['LOG_STDOUT' => 'false']));
        $logger = $sut->create(101, '/tmp/foo', 'unittest');

        $handlers = $logger->getHandlers();
        self::assertArrayHasKey(0, $handlers);
        self::assertInstanceOf(RotatingFileHandler::class, $handlers[0]);
    }
}
