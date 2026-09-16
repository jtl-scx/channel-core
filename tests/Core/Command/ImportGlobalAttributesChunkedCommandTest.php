<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Command;

use Generator;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\ChunkedGlobalAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\Attribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportGlobalAttributesChunkedCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportGlobalAttributesChunkedCommand
 */
class ImportGlobalAttributesChunkedCommandTest extends TestCase
{
    public function testSendsEveryChunkYieldedByTheLoader(): void
    {
        $firstChunk = $this->createAttributeList(2, 'a');
        $secondChunk = $this->createAttributeList(3, 'b');

        $loader = $this->createMock(ChunkedGlobalAttributeLoader::class);
        $loader->expects($this->once())
            ->method('loadChunked')
            ->willReturn([$firstChunk, $secondChunk]);

        $sender = $this->createMock(GlobalAttributeSender::class);
        $sentChunks = [];
        $sender->expects($this->exactly(2))
            ->method('send')
            ->willReturnCallback(function (AttributeList $chunk) use (&$sentChunks): void {
                $sentChunks[] = $chunk;
            });

        $commandTester = $this->execute($loader, $sender);

        self::assertSame([$firstChunk, $secondChunk], $sentChunks);
        self::assertSame(0, $commandTester->getStatusCode());
    }

    public function testReportsTheTotalAmountOfSentAttributes(): void
    {
        $loader = $this->createMock(ChunkedGlobalAttributeLoader::class);
        $loader->method('loadChunked')->willReturn([
            $this->createAttributeList(2, 'a'),
            $this->createAttributeList(3, 'b'),
        ]);

        $commandTester = $this->execute($loader, $this->createMock(GlobalAttributeSender::class));

        self::assertStringContainsString('Successfully sent 5 global Attributes to SCX', $commandTester->getDisplay());
    }

    public function testSendsNothingWhenTheLoaderYieldsNoChunk(): void
    {
        $loader = $this->createMock(ChunkedGlobalAttributeLoader::class);
        $loader->method('loadChunked')->willReturn([]);

        $sender = $this->createMock(GlobalAttributeSender::class);
        $sender->expects($this->never())->method('send');

        $commandTester = $this->execute($loader, $sender);

        self::assertSame(0, $commandTester->getStatusCode());
        self::assertStringContainsString('Successfully sent 0 global Attributes to SCX', $commandTester->getDisplay());
    }

    /**
     * The whole point of the command: a chunk must be sent (and become collectable) before the
     * loader resolves the next one. If the command materialised the generator first, peak memory
     * would be no better than the non-chunked command.
     */
    public function testSendsEachChunkBeforeTheLoaderResolvesTheNextOne(): void
    {
        $events = [];

        $loader = $this->createMock(ChunkedGlobalAttributeLoader::class);
        $loader->method('loadChunked')->willReturnCallback(
            function () use (&$events): Generator {
                $events[] = 'load:a';
                yield $this->createAttributeList(1, 'a');
                $events[] = 'load:b';
                yield $this->createAttributeList(1, 'b');
            }
        );

        $sender = $this->createMock(GlobalAttributeSender::class);
        $sender->method('send')->willReturnCallback(
            function (AttributeList $chunk) use (&$events): void {
                /** @var Attribute $first */
                $first = $chunk->offsetGet(0);
                $events[] = 'send:' . $first->getAttributeId();
            }
        );

        $this->execute($loader, $sender);

        self::assertSame(['load:a', 'send:a-0', 'load:b', 'send:b-0'], $events);
    }

    private function execute(
        ChunkedGlobalAttributeLoader $loader,
        GlobalAttributeSender $sender
    ): CommandTester {
        $sut = new ImportGlobalAttributesChunkedCommand($loader, $sender, $this->createMock(ScxLogger::class));
        $commandTester = new CommandTester($sut);
        $commandTester->execute([]);

        return $commandTester;
    }

    private function createAttributeList(int $amount, string $prefix): AttributeList
    {
        $attributeList = new AttributeList();
        for ($i = 0; $i < $amount; $i++) {
            $attributeList->add(new Attribute("{$prefix}-{$i}", "Attribute {$prefix}-{$i}"));
        }

        return $attributeList;
    }
}
