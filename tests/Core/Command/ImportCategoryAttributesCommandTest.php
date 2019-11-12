<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Command\ImportCategoryAttributesCommand;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCategoryAttributesCommandTest
 * @package Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\ImportCategoryAttributesCommand
 */
class ImportCategoryAttributesCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    private function createInputInterfaceMock(): InputInterface
    {
        $inputMock = Mockery::mock(InputInterface::class);
        $inputMock->shouldReceive('bind');
        $inputMock->shouldReceive('isInteractive')
            ->andReturn(false);

        $inputMock->shouldReceive('hasArgument')
            ->with('command')
            ->once()
            ->andReturn(false);

        $inputMock->shouldReceive('validate');

        return $inputMock;
    }

    public function testCanExecuteCommand(): void
    {
        $categoryId = random_int(1, 10000);
        $process = false;

        $loader = Mockery::mock(MetaDataAttributeLoader::class);
        $updater = Mockery::mock(CategoryAttributeUpdater::class);
        /** @var Mockery\MockInterface $input */
        $input = $this->createInputInterfaceMock();
        $output = Mockery::mock(OutputInterface::class);
        $attributeList = Mockery::mock(CategoryAttributeList::class);

        $input->shouldReceive('getArgument')
            ->once()
            ->with('categoryId')
            ->andReturn($categoryId);

        $input->shouldReceive('getOption')
            ->once()
            ->with('process')
            ->andReturn($process);

        $loader->shouldReceive('fetch')
            ->once()
            ->with($categoryId)
            ->andReturn($attributeList);

        $updater->shouldNotReceive('update');

        $this->expectOutputRegex('/.*/');
        $command = new ImportCategoryAttributesCommand($loader, $updater);
        $command->run($input, $output);

        $this->assertTrue(true);
    }

    public function testCanExecuteCommandAndProcessData(): void
    {
        $categoryId = (string)random_int(1, 10000);
        $process = true;

        $loader = Mockery::mock(MetaDataAttributeLoader::class);
        $updater = Mockery::mock(CategoryAttributeUpdater::class);
        /** @var Mockery\MockInterface $input */
        $input = $this->createInputInterfaceMock();
        $output = Mockery::mock(OutputInterface::class);
        $attributeList = Mockery::mock(CategoryAttributeList::class);

        $input->shouldReceive('getArgument')
            ->once()
            ->with('categoryId')
            ->andReturn($categoryId);

        $input->shouldReceive('getOption')
            ->once()
            ->with('process')
            ->andReturn($process);

        $loader->shouldReceive('fetch')
            ->once()
            ->with((int)$categoryId)
            ->andReturn($attributeList);

        $updater->shouldReceive('update')
            ->once()
            ->with($categoryId, $attributeList);

        $command = new ImportCategoryAttributesCommand($loader, $updater);
        $command->run($input, $output);

        $this->assertTrue(true);
    }
}
