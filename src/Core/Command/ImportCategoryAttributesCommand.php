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
use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion;
use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCategoryAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'import:category-attributes';

    /**
     * @var MetaDataAttributeLoader
     */
    private $categoryAttributeLoader;

    /**
     * @var CategoryAttributeUpdater
     */
    private $attributeUpdater;

    protected function configure()
    {
        $this->setDescription('Import category attributes from marketplace and push to SCX')
            ->addArgument('categoryId', InputArgument::OPTIONAL, 'The category ID for which attributes will be imported')
            ->addOption('process', 'p', InputOption::VALUE_NONE, 'Send data to SCX')
            ->addOption('import-list', 'i', InputOption::VALUE_REQUIRED, 'Import attributes from a file containing a list of category ids (comma separated)');
    }

    /**
     * ImportCategoryAttributesCommand constructor.
     * @param MetaDataAttributeLoader $categoryAttributeLoader
     * @param CategoryAttributeUpdater $attributeUpdater
     */
    public function __construct(
        MetaDataAttributeLoader $categoryAttributeLoader,
        CategoryAttributeUpdater $attributeUpdater
    ) {
        parent::__construct();
        $this->categoryAttributeLoader = $categoryAttributeLoader;
        $this->attributeUpdater = $attributeUpdater;
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
        $categoryId = $input->getArgument('categoryId');
        $process = $input->getOption('process');
        $importFile = $input->getOption('import-list');

        if ($importFile !== null && file_exists($importFile)) {
            $output->writeln("Importing file {$importFile}. This may take a few minutes.");
            $categoryIdList = explode(',', file_get_contents($importFile));

            foreach ($categoryIdList as $categoryId) {
                $this->import($categoryId, true);
            }
        } elseif ($categoryId !== null) {
            $this->import($categoryId, $process);
        } else {
            die("Not enough arguments (missing: 'categoryId')\n");
        }
    }

    /**
     * @param string $categoryId
     * @param bool $process
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusExceprion
     */
    private function import(string $categoryId, bool $process): void
    {
        $attributeList = $this->categoryAttributeLoader->fetch((int)$categoryId);

        if ($attributeList !== null) {
            if ($process === true) {
                $this->attributeUpdater->update($categoryId, $attributeList);
            } else {
                var_export($attributeList);
            }
        }
    }
}
