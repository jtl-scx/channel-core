<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Command\ImportCategoryAttributesCommand;
use JTL\SCX\Lib\Channel\Core\Log\ContextLogger;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportCategoryAttributesCommandTest
 * @package Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportCategoryAttributesCommand
 */
class ImportCategoryAttributesCommandTest extends TestCase
{
    public function testCanFetchAttributeForCategoryWithResults()
    {
        $testCategoryId = uniqid('testCategoryId');
        $testAttributeList = $this->createMock(AttributeList::class);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with($testCategoryId)
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);

        $cmd = new ImportCategoryAttributesCommand($loaderMock, $updaterMock, $this->createStub(ContextLogger::class));
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('AttributeList', $output);
    }

    public function testCanProcessAttributeForCategoryWithResults()
    {
        $testCategoryId = uniqid('testCategoryId');
        $testAttributeList = $this->createMock(AttributeList::class);
        $testAttributeList->expects($this->once())->method('count')->willReturn(1);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with($testCategoryId)
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);

        $cmd = new ImportCategoryAttributesCommand($loaderMock, $updaterMock, $this->createStub(ContextLogger::class));
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
            '--process' => true
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('Fetch CategoryAttributes', $output);
        $this->assertStringContainsString('Update 1 CategoryAttributes ... done', $output);
    }

    public function testCanFetchAttributeForCategoryWithNoResults()
    {
        $testCategoryId = uniqid('testCategoryId');
        $testAttributeList = null;

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with($testCategoryId)
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);

        $cmd = new ImportCategoryAttributesCommand($loaderMock, $updaterMock, $this->createStub(ContextLogger::class));
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('No Attributes available for categoryId', $output);
    }

    public function testCanProcessAttributeForCSVListWithResults()
    {
        $testCategoryId1 = uniqid('testCategoryId');
        $testCategoryId2 = uniqid('testCategoryId');

        $testFilePath = sys_get_temp_dir() . '/' . __CLASS__ . '_' . __METHOD__;
        $fp = fopen($testFilePath, "w+");
        fputcsv($fp, [$testCategoryId1]);
        fputcsv($fp, [$testCategoryId2]);

        $testAttributeList = $this->createMock(AttributeList::class);
        $testAttributeList->expects($this->any())->method('count')->willReturn(1);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->exactly(2))->method('fetch')
            ->withConsecutive([$testCategoryId1], [$testCategoryId2])
            ->willReturnOnConsecutiveCalls($testAttributeList, null);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);

        $cmd = new ImportCategoryAttributesCommand($loaderMock, $updaterMock, $this->createStub(ContextLogger::class));
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            '--import-csv-list' => $testFilePath,
            '--process' => true
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();

        $this->assertStringContainsString("Fetch CategoryAttributes for \"$testCategoryId1\"", $output);
        $this->assertStringContainsString("Fetch CategoryAttributes for \"$testCategoryId2\"", $output);
        $this->assertStringContainsString('Update 1 CategoryAttributes ... done', $output);
        $this->assertStringContainsString("No Attributes available for categoryId \"$testCategoryId2\"", $output);
    }
}
