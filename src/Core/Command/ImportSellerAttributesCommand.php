<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\SellerAttributeUpdater;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportSellerAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'import:seller-attributes';

    /**
     * @var SellerAttributeLoader
     */
    private $attributeLoader;

    /**
     * @var SellerAttributeUpdater
     */
    private $attributeUpdater;

    public function __construct(SellerAttributeLoader $attributeLoader, SellerAttributeUpdater $attributeUpdater)
    {
        parent::__construct();
        $this->attributeLoader = $attributeLoader;
        $this->attributeUpdater = $attributeUpdater;
    }

    protected function configure()
    {
        $this->setDescription('Import global attributes from marketplace and push to SCX')
            ->addArgument(
                'sellerId',
                InputArgument::REQUIRED,
                "For which seller should the Attributes be importet?"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $sellerId = $input->getArgument('sellerId');
        $output->write("Fetch SellerAttributes for '{$sellerId}'");
        $attributeList = $this->attributeLoader->fetchAll();
        $output->writeln(" ... done");
        $output->write("Update {$attributeList->count()} SellerAttributes");
        $this->attributeUpdater->update($sellerId, $attributeList);
        $output->writeln(" ... done");
    }
}