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
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataCategoryAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
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

    private MetaDataCategoryAttributeLoader $categoryAttributeLoader;
    private CategoryAttributeUpdater $attributeUpdater;
    private CategoryAttributeDeleter $categoryAttributeDeleter;

    public function __construct(
        MetaDataCategoryAttributeLoader $categoryAttributeLoader,
        CategoryAttributeUpdater $attributeUpdater,
        CategoryAttributeDeleter $categoryAttributeDeleter,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->categoryAttributeLoader = $categoryAttributeLoader;
        $this->attributeUpdater = $attributeUpdater;
        $this->categoryAttributeDeleter = $categoryAttributeDeleter;
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
                'prune',
                null,
                InputOption::VALUE_REQUIRED,
                'Delete all categories before sending them',
                true
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $categoryId = $input->getArgument('categoryId');
        $process = $input->getOption('process');

        $importFile = $input->getOption('import-csv-list');
        $prune = (bool)$input->getOption('prune');

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
                $this->import(trim($row[$column]), $process, $io, $prune);
            }
        } else {
            $this->import($categoryId, $process, $io, $prune);
        }

        return 0;
    }

    /**
     * @param string|null $categoryId
     * @param bool $process
     * @param SymfonyStyle $io
     * @param bool $prune
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws UnexpectedStatusException
     */
    private function import(?string $categoryId, bool $process, SymfonyStyle $io, bool $prune): void
    {
        $io->write("Fetch CategoryAttributes for");
        if ($categoryId === null) {
            $io->write(" all Categories");
        } else {
            $io->write(" '{$categoryId}'");
        }
        $categoryIdList = is_null($categoryId)?null: [$categoryId];
        $categoryAttributeList = $this->categoryAttributeLoader->fetch($categoryIdList);
        $io->writeln(" ... done");

        if ($prune) {
            $io->write('Pruning channel categories...');
            $this->categoryAttributeDeleter->delete();
            $io->writeln('done');
        }

        if ($categoryAttributeList instanceof CategoryAttributeList) {
            /** @var CategoryAttribute $categoryAttribute */
            foreach ($categoryAttributeList as $categoryAttribute) {
                if ($process === true) {
                    $io->write("Update Category {$categoryAttribute->getCategoryId()} with {$categoryAttribute->getAttributeList()->count()} Attributes");
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
