<?php


namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

abstract class AbstractEmitterCommandTestCaseHelper extends TestCase
{
    protected function createSystemOfTest(string $className, AmqpEmitter $emitterMock): CommandTester
    {
        self::assertTrue(class_exists($className), "Class {$className} does not exists");

        $command = new $className(
            $this->createStub(Environment::class),
            new EventFactory(),
            $emitterMock,
            new ChannelApiResponseDeserializer(),
            $this->createStub(ScxLogger::class)
        );

        return new CommandTester($command);
    }

    protected function buildEmitterMock(string $expectedEventClass): AmqpEmitter
    {
        $emitterMock = $this->createMock(AmqpEmitter::class);
        $emitterMock->expects($this->exactly(1))
            ->method('emit')
            ->with($this->isInstanceOf($expectedEventClass));

        return $emitterMock;
    }
}
