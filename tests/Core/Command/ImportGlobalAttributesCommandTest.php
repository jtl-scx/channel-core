<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/15
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\GlobalAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportGlobalAttributesCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportGlobalAttributesCommand
 */
class ImportGlobalAttributesCommandTest extends TestCase
{
    public function testCanLoadGlobalAttributes(): void
    {
        $globalAttributeLoader = $this->createMock(GlobalAttributeLoader::class);
        $globalAttributeSender = $this->createMock(GlobalAttributeSender::class);
        $logger = $this->createMock(ScxLogger::class);

        $attributeList = new AttributeList();
        $globalAttributeLoader->expects($this->once())->method('load')->willReturn($attributeList);
        $globalAttributeSender->expects($this->once())->method('send')->with($attributeList);

        $sut = new ImportGlobalAttributesCommand($globalAttributeLoader, $globalAttributeSender, $logger);
        $commandTester = new CommandTester($sut);
        $commandTester->execute([]);
    }
}
