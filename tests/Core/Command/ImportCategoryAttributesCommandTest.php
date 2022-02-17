<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Lock\Lock;
use JTL\SCX\Lib\Channel\Core\Lock\LockFactory;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeDeleter;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
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
        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList($testCategoryId, $this->createStub(AttributeList::class));

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with([$testCategoryId])
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('AttributeList', $output);
    }

    public function testCanProcessAllCategories()
    {
        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList('egal', $this->createStub(AttributeList::class));

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with(null)
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('Fetch CategoryAttributes for all Categories', $output);
        $this->assertStringContainsString('AttributeList', $output);
    }

    public function testCanProcessAttributeForCategoryWithResults()
    {
        $testCategoryId = uniqid('testCategoryId');
        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->once())->method('count')->willReturn(1);
        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList($testCategoryId, $attrList);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with([$testCategoryId])
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
            '--process' => true,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('Fetch CategoryAttributes', $output);
        $this->assertStringContainsString("Update Category Id: {$testCategoryId} with 1 Attributes ... done", $output);
    }

    /**
     * @test
     */
    public function it_will_delete_attribute_per_category_on_default(): void
    {
        $testCategoryId = uniqid('testCategoryId');
        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->once())->method('count')->willReturn(1);

        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList($testCategoryId, $attrList);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with([$testCategoryId])
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);
        $deleterMock->expects(self::once())->method('delete')->with($testCategoryId);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
            '--process' => true
        ]);

        self::assertFalse(
            $cmdTester->getInput()->getOption('keep-attributes'),
            'Option --keep-attributes must be disabled on this test run'
        );

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString("Delete Attributes in Category {$testCategoryId} ... done\n", $output);
    }


    public function testCanFetchAttributeForCategoryWithNoResults()
    {
        $testCategoryId = uniqid('testCategoryId');
        $testAttributeList = null;

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->once())->method('fetch')
            ->with([$testCategoryId])
            ->willReturn($testAttributeList);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();
        $this->assertStringContainsString('No category-attributes available', $output);
    }

    public function testCanProcessAttributeForCSVListWithResults()
    {
        $testCategoryId1 = uniqid('testCat');
        $testCategoryId2 = uniqid('testCat');

        $testFilePath = sys_get_temp_dir() . '/' . __CLASS__ . '_' . __METHOD__;
        $fp = fopen($testFilePath, "w+");
        fputcsv($fp, [$testCategoryId1]);
        fputcsv($fp, [$testCategoryId2]);

        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->atLeastOnce())->method('count')->willReturn(1);
        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList($testCategoryId1, $attrList);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->exactly(2))->method('fetch')
            ->withConsecutive([[$testCategoryId1]], [[$testCategoryId2]])
            ->willReturnOnConsecutiveCalls($testAttributeList, null);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            '--import-csv-list' => $testFilePath,
            '--process' => true,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();

        $this->assertStringContainsString("Fetch CategoryAttributes for '{$testCategoryId1}'", $output);
        $this->assertStringContainsString("Fetch CategoryAttributes for '{$testCategoryId2}'", $output);
        $this->assertStringContainsString("Update Category Id: {$testCategoryId1} with 1 Attributes ... done", $output);
        $this->assertStringContainsString("No category-attributes available", $output);
    }

    public function testItWillNotDeleteExistingAttributesWhenKeepAttributesIsSet(): void
    {
        $testCategoryId1 = uniqid('testCat', true);
        $testCategoryId2 = uniqid('testCat', true);

        $testFilePath = sys_get_temp_dir() . '/' . __CLASS__ . '_' . __METHOD__;
        $fp = fopen($testFilePath, 'wb+');
        fputcsv($fp, [$testCategoryId1]);
        fputcsv($fp, [$testCategoryId2]);

        $attrList = $this->createMock(AttributeList::class);
        $attrList->expects($this->atLeastOnce())->method('count')->willReturn(1);
        $testAttributeList = new CategoryAttributeList();
        $testAttributeList->addAttributeList($testCategoryId1, $attrList);

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $loaderMock->expects($this->exactly(2))->method('fetch')
            ->withConsecutive([[$testCategoryId1]], [[$testCategoryId2]])
            ->willReturnOnConsecutiveCalls($testAttributeList, null);

        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);

        $deleterMock->expects(self::never())->method('delete');

        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(true);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            '--import-csv-list' => $testFilePath,
            '--process' => true,
            '--keep-attributes' => true,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());

        $output = $cmdTester->getDisplay();

        $this->assertStringContainsString("Fetch CategoryAttributes for '{$testCategoryId1}'", $output);
        $this->assertStringContainsString("Fetch CategoryAttributes for '{$testCategoryId2}'", $output);
        $this->assertStringContainsString("Update Category Id: {$testCategoryId1} with 1 Attributes ... done", $output);
        $this->assertStringContainsString("No category-attributes available", $output);
    }

    public function testWillStopIfProcessIsLocked()
    {
        $testCategoryId = uniqid('testCategoryId');

        $loaderMock = $this->createMock(MetaDataCategoryAttributeLoader::class);
        $updaterMock = $this->createMock(CategoryAttributeUpdater::class);
        $deleterMock = $this->createMock(CategoryAttributeDeleter::class);
        $lockFactory = $this->createMock(LockFactory::class);

        $lockFactory->expects($this->once())
            ->method('obtain')
            ->willReturn(false);

        $cmd = new ImportCategoryAttributesCommand(
            $loaderMock,
            $updaterMock,
            $deleterMock,
            $lockFactory,
            $this->createStub(ScxLogger::class)
        );
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute([
            'categoryId' => $testCategoryId,
        ]);

        $this->assertEquals(0, $cmdTester->getStatusCode());
    }
}
