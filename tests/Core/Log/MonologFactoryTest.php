<?php

namespace JTL\SCX\Lib\Channel\Core\Log;

use Monolog\Handler\RotatingFileHandler;
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
        $sut = new MonologFactory();
        $logger = $sut->create(101, '/tmp/foo', 'unittest');

        // check log-level
        self::assertTrue($logger->isHandling(101));

        $handlers = $logger->getHandlers();
        self::assertArrayHasKey(0, $handlers);
        self::assertInstanceOf(RotatingFileHandler::class, $handlers[0]);
    }
}
