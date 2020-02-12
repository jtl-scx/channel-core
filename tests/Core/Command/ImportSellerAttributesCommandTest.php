<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Log\ContextLogger;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\SellerAttributeUpdater;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportSellerAttributesCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportSellerAttributesCommand
 */
class ImportSellerAttributesCommandTest extends TestCase
{
    public function testCanImportSellerAttributes(): void
    {
        $sellerId = uniqid('sellerId', true);

        $numAttr = random_int(5, 100);
        $attrListMock = $this->createMock(AttributeList::class);
        $attrListMock->method('count')->willReturn($numAttr);

        $attrLoaderMock = $this->createMock(SellerAttributeLoader::class);
        $attrLoaderMock->expects($this->atLeastOnce())->method('fetchAll')->willReturn($attrListMock);

        $attrUpdaterMock = $this->createMock(SellerAttributeUpdater::class);
        $attrUpdaterMock->expects($this->atLeastOnce())->method('update')->with($sellerId, $attrListMock);

        $command = new ImportSellerAttributesCommand(
            $attrLoaderMock,
            $attrUpdaterMock,
            $this->createStub(ContextLogger::class)
        );
        $cmdTester = new CommandTester($command);
        $cmdTester->execute(['sellerId' => $sellerId]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString("Update {$numAttr} SellerAttributes", $output);
    }
}
