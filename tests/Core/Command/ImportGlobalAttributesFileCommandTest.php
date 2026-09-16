<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/15
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeFileReader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportGlobalAttributesFileCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Core\Command\ImportGlobalAttributesFileCommand::class)]
class ImportGlobalAttributesFileCommandTest extends TestCase
{
    public function testCanLoadGlobalAttributesFromFile(): void
    {
        $fileReader = $this->createMock(GlobalAttributeFileReader::class);
        $attributeSender = $this->createMock(GlobalAttributeSender::class);
        $logger = $this->createStub(ScxLogger::class);
        $attributeList = new AttributeList();


        $filename = uniqid('fileName', true);

        $fileReader->expects($this->once())->method('read')->with($filename)->willReturn($attributeList);
        $attributeSender->expects($this->once())->method('send')->with($attributeList);

        $sut = new ImportGlobalAttributesFileCommand($fileReader, $attributeSender, $logger);
        $commandTester = new CommandTester($sut);

        $commandTester->execute(['filename' => $filename]);
    }
}
