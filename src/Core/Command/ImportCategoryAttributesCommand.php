<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/2019
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use JTL\SCX\Lib\Channel\Core\Lock\LockFactory;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttribute;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeDeleter;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCategoryAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.attributes-category';
    private const LOCK_KEY = 'scx-api:put.attributes-category';

    private MetaDataCategoryAttributeLoader $categoryAttributeLoader;
    private CategoryAttributeUpdater $attributeUpdater;
    private CategoryAttributeDeleter $categoryAttributeDeleter;
    private LockFactory $lockFactory;

    public function __construct(
        MetaDataCategoryAttributeLoader $categoryAttributeLoader,
        CategoryAttributeUpdater $attributeUpdater,
        CategoryAttributeDeleter $categoryAttributeDeleter,
        LockFactory $lockFactory,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->categoryAttributeLoader = $categoryAttributeLoader;
        $this->attributeUpdater = $attributeUpdater;
        $this->categoryAttributeDeleter = $categoryAttributeDeleter;
        $this->lockFactory = $lockFactory;
    }

    protected function configure()
    {
        $this->setDescription('Import category attributes from marketplace and push to SCX')
            ->addArgument(
                'categoryId',
                InputArgument::OPTIONAL,
                'The category ID for which attributes will be imported'
            )
            ->addOption(
                'process',
                'p',
                InputOption::VALUE_NONE,
                'Send data to SCX Channel API'
            )
            ->addOption(
                'import-csv-list',
                'i',
                InputOption::VALUE_REQUIRED,
                'Import attributes from a csv file containing a list of category ids'
            )
            ->addOption(
                'import-csv-delimiter',
                null,
                InputOption::VALUE_REQUIRED,
                'Import csv file with selected delimiter',
                ','
            )
            ->addOption(
                'import-csv-enclosure',
                null,
                InputOption::VALUE_REQUIRED,
                'Import file with selected separator',
                '"'
            )
            ->addOption(
                'import-csv-categoryid-column',
                null,
                InputOption::VALUE_REQUIRED,
                'Read category Id from specific column',
                '0'
            )
            ->addOption(
                'keep-attributes',
                null,
                InputOption::VALUE_NONE,
                'Set flag to keep existing Category Attributes. The default behaviour will delete existing attributes first.'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws UnexpectedStatusException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $lock = $this->lockFactory->createLock(self::LOCK_KEY, 45);
        if (!$this->lockFactory->obtain($lock)) {
            $this->io->info("Process is locked");
            return 0;
        }

        $categoryId = $input->getArgument('categoryId');
        $process = $input->getOption('process');

        $importFile = $input->getOption('import-csv-list');
        $keepAttributes = $input->getOption('keep-attributes');

        if ($process === false) {
            $this->io->warning("There is no --process option given - attributes are NOT send to SCX-Channel-Api");
        }

        if ($importFile !== null && file_exists($importFile)) {
            $output->writeln("Importing CategoryAttributes from file \"{$importFile}\". This may take a few minutes.");

            $delimiter = $input->getOption('import-csv-delimiter');
            $enclosure = $input->getOption('import-csv-enclosure');
            $column = (int)$input->getOption('import-csv-categoryid-column');

            $file = fopen($importFile, "r");
            while (($row = fgetcsv($file, 0, $delimiter, $enclosure)) !== false) {
                $this->import(trim($row[$column]), $process, $io, $keepAttributes);
            }
        } else {
            $this->import($categoryId, $process, $io, $keepAttributes);
        }

        return 0;
    }

    /**
     * @param string|null $categoryId
     * @param bool $process
     * @param SymfonyStyle $io
     * @param bool $keepAttributes
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws UnexpectedStatusException
     */
    private function import(?string $categoryId, bool $process, SymfonyStyle $io, bool $keepAttributes): void
    {
        $io->write("Fetch CategoryAttributes for");
        if ($categoryId === null) {
            $io->write(" all Categories");
        } else {
            $io->write(" '{$categoryId}'");
        }
        $categoryIdList = is_null($categoryId) ? null : [$categoryId];
        $categoryAttributeList = $this->categoryAttributeLoader->fetch($categoryIdList);
        $io->writeln(" ... done");

        if ($categoryAttributeList instanceof CategoryAttributeList) {
            /** @var CategoryAttribute $categoryAttribute */
            foreach ($categoryAttributeList as $categoryAttribute) {
                if ($process === true) {
                    if ($keepAttributes === false) {
                        $io->write("Delete Attributes in Category {$categoryAttribute->getCategoryId()}");
                        $this->categoryAttributeDeleter->delete($categoryAttribute->getCategoryId());
                        $io->writeln(' ... done');
                    }

                    $io->write("Update Category Id: {$categoryAttribute->getCategoryId()} with {$categoryAttribute->getAttributeList()->count()} Attributes");
                    $this->attributeUpdater->update($categoryAttribute);
                    $io->writeln(" ... done");
                } else {
                    $io->writeln("");
                    $io->writeln(var_export($categoryAttribute, true));
                }
            }
            return;
        }

        $io->caution("No category-attributes available");
    }
}
