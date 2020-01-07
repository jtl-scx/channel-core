<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
use JTL\SCX\Lib\Channel\MetaData\Category;
use JTL\SCX\Lib\Channel\MetaData\CategoryList;
use JTL\SCX\Lib\Channel\MetaData\CategoryTreeUpdater;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportCategoryTreeCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportCategoryTreeCommand
 */
class ImportCategoryTreeCommandTest extends TestCase
{
    public function testCanFetchAndUpdateCategoryTree(): void
    {
        $version = uniqid('version', true);
        $categoryList = new CategoryList();

        $loaderMock = $this->createMock(MetaCategoryLoader::class);
        $loaderMock->expects($this->once())->method('fetchAll')->willReturn($categoryList);

        $updaterMock = $this->createMock(CategoryTreeUpdater::class);
        $updaterMock->expects($this->once())->method('update')->willReturn($version);

        $command = new ImportCategoryTreeCommand($loaderMock, $updaterMock);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $this->assertStringContainsString($version, $commandTester->getDisplay());
    }

    public function testCanWriteCategoryIDsToFile(): void
    {
        $categoryList = new CategoryList();
        $categoryList[] = new Category("cat1", 'foo', "");
        $categoryList[] = new Category("2cat", 'foo', "");

        $loaderMock = $this->createMock(MetaCategoryLoader::class);
        $loaderMock->expects($this->once())->method('fetchAll')->willReturn($categoryList);

        $updaterMock = $this->createStub(CategoryTreeUpdater::class);

        $testFilePath = sys_get_temp_dir() . '/' . __CLASS__ . '_' . __METHOD__;
        $command = new ImportCategoryTreeCommand($loaderMock, $updaterMock);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--dump-categories-to-file' => $testFilePath
        ]);

        $expectation = <<< CSV
cat1
2cat

CSV;
        $this->assertEquals($expectation, file_get_contents($testFilePath));
    }
}
