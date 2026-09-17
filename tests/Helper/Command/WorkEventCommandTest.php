<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\Nachricht\Message\Cache\MessageCache;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Tester\CommandTester;

#[CoversClass(WorkEventCommand::class)]
class WorkEventCommandTest extends TestCase
{
    private string $fixtureDir;

    protected function setUp(): void
    {
        $this->fixtureDir = sys_get_temp_dir() . '/work-event-command-test';
        @mkdir($this->fixtureDir);
        file_put_contents(
            $this->fixtureDir . '/event.json',
            json_encode(['sellerId' => 'seller1'], JSON_THROW_ON_ERROR)
        );
    }

    protected function tearDown(): void
    {
        @unlink($this->fixtureDir . '/event.json');
        @rmdir($this->fixtureDir);
    }

    public function testInvokesEveryRegisteredListenerAndReturnsSuccess(): void
    {
        $spyListener = new class () {
            public int $calls = 0;

            public function processShippingAttributes($message): void
            {
                $this->calls++;
            }
        };

        $environment = $this->createMock(Environment::class);
        $environment->method('get')->with('ROOT_DIRECTORY')->willReturn($this->fixtureDir);

        $messageCache = $this->createMock(MessageCache::class);
        $messageCache->method('getListenerListForMessage')->willReturn([
            ['listenerClass' => 'spy.listener', 'method' => 'processShippingAttributes'],
        ]);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with('spy.listener')->willReturn($spyListener);

        $command = new WorkEventCommand(
            $environment,
            new EventFactory(),
            new ChannelApiResponseDeserializer(),
            $messageCache,
            $container,
            $this->createStub(ScxLogger::class)
        );

        $tester = new CommandTester($command);
        $exitCode = $tester->execute([
            '--type' => 'SellerMetaSellerAttributesUpdateRequest',
            'jsonFile' => '/event.json',
        ]);

        self::assertSame(WorkEventCommand::SUCCESS, $exitCode);
        self::assertSame(1, $spyListener->calls);
        self::assertStringContainsString('spy.listener::processShippingAttributes', $tester->getDisplay());
    }

    public function testReturnsNonZeroExitCodeWhenAListenerThrows(): void
    {
        $throwingListener = new class () {
            public function processShippingAttributes($message): void
            {
                throw new \RuntimeException('boom');
            }
        };

        $environment = $this->createMock(Environment::class);
        $environment->method('get')->with('ROOT_DIRECTORY')->willReturn($this->fixtureDir);

        $messageCache = $this->createMock(MessageCache::class);
        $messageCache->method('getListenerListForMessage')->willReturn([
            ['listenerClass' => 'throwing.listener', 'method' => 'processShippingAttributes'],
        ]);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with('throwing.listener')->willReturn($throwingListener);

        $command = new WorkEventCommand(
            $environment,
            new EventFactory(),
            new ChannelApiResponseDeserializer(),
            $messageCache,
            $container,
            $this->createStub(ScxLogger::class)
        );

        $tester = new CommandTester($command);
        $exitCode = $tester->execute([
            '--type' => 'SellerMetaSellerAttributesUpdateRequest',
            'jsonFile' => '/event.json',
        ]);

        self::assertSame(WorkEventCommand::FAILURE, $exitCode);
        self::assertStringContainsString('boom', $tester->getDisplay());
    }

    public function testRejectsUnknownEventType(): void
    {
        $environment = $this->createMock(Environment::class);

        $command = new WorkEventCommand(
            $environment,
            new EventFactory(),
            new ChannelApiResponseDeserializer(),
            $this->createMock(MessageCache::class),
            $this->createMock(ContainerInterface::class),
            $this->createStub(ScxLogger::class)
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown EventType 'NotARealEventType'");

        $tester = new CommandTester($command);
        $tester->execute([
            '--type' => 'NotARealEventType',
            'jsonFile' => '/event.json',
        ]);
    }
}
