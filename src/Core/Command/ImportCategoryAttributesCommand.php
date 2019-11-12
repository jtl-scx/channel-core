<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/2019
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\MetaDataAttributeLoader;
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
            ->addArgument('categoryId', InputArgument::REQUIRED, 'The category ID for which attributes will be imported')
            ->addOption('process', 'p', InputOption::VALUE_NONE, 'Send data to SCX');
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     * @throws \JTL\SCX\Client\Exception\RequestValidationFailedException
     * @throws \JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusExceprion
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $categoryId = $input->getArgument('categoryId');
        $process = $input->getOption('process');
        $attributeList = $this->categoryAttributeLoader->fetch((int)$categoryId);

        if ($attributeList !== null) {
            if ($process === true) {
                $this->attributeUpdater->update($categoryId, $attributeList);
            } else {
                var_dump($attributeList);
            }
        }
    }
}
