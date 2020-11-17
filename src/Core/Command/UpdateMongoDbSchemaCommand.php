<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-10
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Database\Migration\CollectionSchemaLoader;
use JTL\SCX\Lib\Channel\Database\Migration\SchemaUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateMongoDbSchemaCommand extends AbstractCommand
{
    protected static $defaultName = 'db:schema-up';

    private CollectionSchemaLoader $loader;
    private SchemaUpdater $schemaUpdater;

    public function __construct(CollectionSchemaLoader $loader, SchemaUpdater $schemaUpdater, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->loader = $loader;
        $this->schemaUpdater = $schemaUpdater;
    }

    protected function configure()
    {
        $this->setDescription('Migrate MongoDB Schema (run verbose to see index results)')
            ->addArgument(
                'dbname',
                InputArgument::REQUIRED,
                'Name of the database where the migration needs to run.'
            )
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path in file system where the migration classes are located.'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!extension_loaded("mongodb")) {
            $io->error('Missing "ext-mongo" PHP-Extension');
            return 1;
        }

        $collectionSchemaList = $this->loader->getCollectionSchemaList(realpath($input->getArgument('path')));
        foreach ($collectionSchemaList as $collectionSchemaInstance) {
            $collectionName = $collectionSchemaInstance->getCollectionName();

            $io->section("Update Schema for collection \"{$collectionName}\" ");
            $idxInfo = $this->schemaUpdater->runMigration($collectionSchemaInstance, $input->getArgument('dbname'));
            if ($io->isVerbose()) {
                $io->block(json_encode($idxInfo, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
            }
            $io->success('done');
        }

        return 0;
    }
}
