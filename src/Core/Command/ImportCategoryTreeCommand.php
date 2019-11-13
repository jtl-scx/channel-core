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
            ->addOption('dump-category-ids', 'd', InputOption::VALUE_NONE, 'Dump all category IDs');
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

        $output->writeln('Start requesting categories');
        $categoryList = $this->categoryLoader->fetchAll();
        $output->writeln("Got {$categoryList->count()} Categories");

        if ($dump === true) {
            $categoryIdList = [];
            foreach ($categoryList as $category) {
                $categoryIdList[] = $category->getCategoryId();
            }

            file_put_contents('import_category_tree_ids', implode(',', $categoryIdList));
        }

        $categoryTreeVersion = $this->categoryTreeUpdater->update($categoryList);
        $output->writeln("Updated CategoryTree. New Version: {$categoryTreeVersion}");
    }
}
