<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/04
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\GlobalAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportGlobalAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.attributes-global';

    private GlobalAttributeLoader $globalAttributeLoader;
    private GlobalAttributeSender $globalAttributeSender;

    public function __construct(
        GlobalAttributeLoader $globalAttributeLoader,
        GlobalAttributeSender $globalAttributeSender,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->globalAttributeLoader = $globalAttributeLoader;
        $this->globalAttributeSender = $globalAttributeSender;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $globalAttributeList = $this->globalAttributeLoader->load();
        $output->writeln("Loaded {$globalAttributeList->count()} global Attributes");

        $this->globalAttributeSender->send($globalAttributeList);

        $output->writeln("Successfully send global Attributes to SCX");
        return 0;
    }
}
