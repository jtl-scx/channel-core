<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-08
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;
use JTL\SCX\Lib\Channel\MetaData\CategoryTreeUpdater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCategoryTreeCommand extends AbstractCommand
{
    protected static $defaultName = 'import:category-tree';

    /**
     * @var MetaCategoryLoader
     */
    private $categoryLoader;

    /**
     * @var CategoryTreeUpdater
     */
    private $categoryTreeUpdater;

    protected function configure()
    {
        $this->setDescription('Import Category-Tree from marketplace and push to SCX')
            ->addOption(
                'dump-categories-to-file',
                'd',
                InputOption::VALUE_REQUIRED,
                'Dump all category IDs to CSV file')
            ->addOption(
                'dump-csv-delimiter',
                null,
                InputOption::VALUE_REQUIRED,
                'Delimiter used when dump category IDs to CSV file',
                ',')
            ->addOption(
                'dump-csv-enclosure',
                null,
                InputOption::VALUE_REQUIRED,
                'Enclosure used when dump category IDs to CSV file',
                '"'
            )
        ;
    }

    /**
     * ImportCategoryTreeCommand constructor.
     * @param MetaCategoryLoader $categoryLoader
     * @param CategoryTreeUpdater $categoryTreeUpdater
     */
    public function __construct(
        MetaCategoryLoader $categoryLoader,
        CategoryTreeUpdater $categoryTreeUpdater
    ) {
        parent::__construct();
        $this->categoryLoader = $categoryLoader;
        $this->categoryTreeUpdater = $categoryTreeUpdater;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusExceprion
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $io->write('Start requesting categories');
        $categoryList = $this->categoryLoader->fetchAll();
        $io->writeln(" ... done. {$categoryList->count()} Categories received");

        $dump = $input->getOption('dump-categories-to-file');
        if ($dump !== null) {
            $delimiter = $input->getOption('dump-csv-delimiter');
            $enclosure = $input->getOption('dump-csv-enclosure');

            $fp = fopen($dump, 'w');
            if($fp === false){
                throw new \RuntimeException("Categories could not be dumped. Check if the path exists and is writable!");
            }

            $io->write("Dump category tree to file");
            foreach ($categoryList as $category) {
                fputcsv($fp, [$category->getCategoryId()], $delimiter, $enclosure);
            }
            $io->writeln(' ... done');
        }

        $io->write("Update CategoryTree.");
        $categoryTreeVersion = $this->categoryTreeUpdater->update($categoryList);
        $io->writeln(" ... done. New Version is \"{$categoryTreeVersion}\"");
    }
}
