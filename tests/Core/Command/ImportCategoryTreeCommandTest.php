<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-04
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
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
    public function setUp(): void
    {
        $_ENV['REAL_USER'] = uniqid('user', true);
        $_ENV['REAL_SECRET'] = uniqid('secret', true);
    }

    public function tearDown(): void
    {
        $_ENV['REAL_USER'] = null;
        $_ENV['REAL_SECRET'] = null;
        \Mockery::close();
    }

    public function testIsInstanceOfAbstractCommand(): void
    {
        $this->assertInstanceOf(AbstractCommand::class, new ImportCategoryTreeCommand(
            \Mockery::mock(MetaCategoryLoader::class),
            \Mockery::mock(CategoryTreeUpdater::class)
        ));
    }

    public function testCanBeExecuted(): void
    {
        $version = uniqid('version', true);
        $categoryList = new CategoryList();

        $categoryLoader = \Mockery::mock(MetaCategoryLoader::class);
        $categoryLoader->expects('fetchAll')->andReturn($categoryList);

        $updaterMock = \Mockery::mock(CategoryTreeUpdater::class);
        $updaterMock->expects('update')->andReturn($version);

        $command = new ImportCategoryTreeCommand(
            $categoryLoader,
            $updaterMock
        );
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $this->assertStringContainsString($version, $commandTester->getDisplay());
    }
}
