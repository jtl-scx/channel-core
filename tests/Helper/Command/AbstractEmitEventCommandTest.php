<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use InvalidArgumentException;
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \JTL\SCX\Lib\Channel\Helper\Command\AbstractEmitEventCommand
 */
class AbstractEmitEventCommandTest extends TestCase
{
    private string $testJsonFile;

    public function setUp(): void
    {
        $this->testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        file_put_contents($this->testJsonFile, json_encode([
            'sellerId' => '123',
            'channel' => 'dingens',
            'message' => 'a message',
            'severity' => 'INFO',
        ]));
    }

    public function testCanEmitEventAfterLoadFromJsonFile()
    {
        $emitterMock = $this->createMock(AmqpEmitter::class);
        $emitterMock->expects($this->once())
            ->method('emit')
            ->with($this->isInstanceOf(SystemNotificationEvent::class));

        $concreteCmd = $this->createConcreteCmdInstance($emitterMock);

        $commandTester = new CommandTester($concreteCmd);
        $commandTester->execute([
            'jsonFile' => $this->testJsonFile,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'Event \'JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent\' emitted',
            $output
        );
    }

    public function testCanOverwriteProperties()
    {
        $emitterMock = $this->createMock(AmqpEmitter::class);
        $emitterMock->expects($this->once())
            ->method('emit')
            ->with($this->isInstanceOf(SystemNotificationEvent::class));

        $concreteCmd = $this->createConcreteCmdInstance($emitterMock);

        $commandTester = new CommandTester($concreteCmd);
        $commandTester->execute([
            'jsonFile' => $this->testJsonFile,
            'sellerId' => 'my_unique_sellerId',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'my_unique_sellerId',
            $output
        );
    }

    public function testFailWhenEventSchemaIsInvalid()
    {
        file_put_contents($this->testJsonFile, json_encode([
            'sellerId' => '123',
            // 'channel' => 'dingens', this is required, so we remove it
            'message' => 'a message',
            'severity' => 'INFO',
        ]));

        $emitterMock = $this->createMock(AmqpEmitter::class);
        $emitterMock->expects($this->never())
            ->method('emit');

        $concreteCmd = $this->createConcreteCmdInstance($emitterMock);

        $commandTester = new CommandTester($concreteCmd);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid event schema");
        $this->expectExceptionMessage("'channel' can't be null");
        $commandTester->execute([
            'jsonFile' => $this->testJsonFile,
        ]);
    }


    public function testStopProcessWhenJsonFileNotFound()
    {
        $concreteCmd = $this->createConcreteCmdInstance($this->createStub(AmqpEmitter::class));

        $commandTester = new CommandTester($concreteCmd);
        $this->expectException(RuntimeException::class);
        $commandTester->execute([
            'jsonFile' => '/any/unknown.json',
        ]);
    }

    private function createConcreteCmdInstance(AmqpEmitter $emitterMock): AbstractEmitEventCommand
    {
        $environmentStub = $this->createStub(Environment::class);
        $loggerStub = $this->createStub(ScxLogger::class);

        return new class($environmentStub, new EventFactory(), $emitterMock, new ChannelApiResponseDeserializer(), $loggerStub) extends AbstractEmitEventCommand {
            public function getName(): ?string
            {
                return 'Dummy';
            }

            protected function getEventType(): EventType
            {
                return EventType::SystemNotification();
            }
        };
    }
}
