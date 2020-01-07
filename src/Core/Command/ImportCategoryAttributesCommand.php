<?php declare(strict_types=1);
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
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCategoryAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'import:category-attributes';

    /**
     * @var MetaDataCategoryAttributeLoader
     */
    private $categoryAttributeLoader;

    /**
     * @var CategoryAttributeUpdater
     */
    private $attributeUpdater;

    /**
     * ImportCategoryAttributesCommand constructor.
     * @param MetaDataCategoryAttributeLoader $categoryAttributeLoader
     * @param CategoryAttributeUpdater $attributeUpdater
     */
    public function __construct(
        MetaDataCategoryAttributeLoader $categoryAttributeLoader,
        CategoryAttributeUpdater $attributeUpdater
    ) {
        parent::__construct();
        $this->categoryAttributeLoader = $categoryAttributeLoader;
        $this->attributeUpdater = $attributeUpdater;
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
                0
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $categoryId = $input->getArgument('categoryId');
        $process = $input->getOption('process');

        $importFile = $input->getOption('import-csv-list');

        if ($categoryId !== null) {
            $this->import($categoryId, $process, $io);
        }

        if ($importFile !== null && file_exists($importFile)) {
            $output->writeln("Importing CategoryAttributes from file \"{$importFile}\". This may take a few minutes.");

            $delimiter = $input->getOption('import-csv-delimiter');
            $enclosure = $input->getOption('import-csv-enclosure');
            $column = (int)$input->getOption('import-csv-categoryid-column');

            $file = fopen($importFile, "r");
            while (($row = fgetcsv($file, 0, $delimiter, $enclosure)) !== false) {
                $this->import(trim($row[$column]), $process, $io);
            }

            return;
        }
    }

    /**
     * @param string $categoryId
     * @param bool $process
     * @param SymfonyStyle $io
     *
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusException
     */
    private function import(string $categoryId, bool $process, SymfonyStyle $io): void
    {
        $io->write("Fetch CategoryAttributes for \"{$categoryId}\"");
        $attributeList = $this->categoryAttributeLoader->fetch($categoryId);
        $io->writeln(" ... done");

        if ($attributeList instanceof AttributeList) {
            if ($process === true) {
                $io->write("Update {$attributeList->count()} CategoryAttributes");
                $this->attributeUpdater->update($categoryId, $attributeList);
                $io->writeln(" ... done");
            } else {
                $io->writeln("");
                $io->writeln(var_export($attributeList, true));
            }
            return;
        }

        $io->caution("No Attributes available for categoryId \"$categoryId\"");
    }
}
