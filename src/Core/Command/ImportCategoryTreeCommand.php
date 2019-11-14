<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-11-08
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaCategoryLoader;
use JTL\SCX\Lib\Channel\MetaData\CategoryTreeUpdater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->setDescription('Import Meta Category-Tree from marketplace and push to SCX')
            ->addOption('dump-category-ids', 'd', InputOption::VALUE_REQUIRED, 'Dump all category IDs to file')
            ->addOption('dump-separator', 's', InputOption::VALUE_REQUIRED, 'Separator used for the dump', ',');
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     * @throws \JTL\SCX\Client\Exception\RequestValidationFailedException
     * @throws \JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $dump = $input->getOption('dump-category-ids');
        $sep = $input->getOption('dump-separator');

        $output->writeln('Start requesting categories');
        $categoryList = $this->categoryLoader->fetchAll();
        $output->writeln("Got {$categoryList->count()} Categories");

        if ($dump !== null) {
            $categoryIdList = [];
            foreach ($categoryList as $category) {
                $categoryIdList[] = $category->getCategoryId();
            }

            $success = @file_put_contents($dump, implode($sep, $categoryIdList));

            if ($success === false) {
                $output->writeln('Categories could not be dumped. Check if the path exists and is writable!');
            } else {
                $output->writeln('Categories were dumped successfully');
            }
        }

        $categoryTreeVersion = $this->categoryTreeUpdater->update($categoryList);
        $output->writeln("Updated CategoryTree. New Version: {$categoryTreeVersion}");
    }
}
