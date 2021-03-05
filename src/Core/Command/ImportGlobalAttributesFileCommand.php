<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeFileReader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportGlobalAttributesFileCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.attributes-global-file';

    private GlobalAttributeFileReader $globalAttributeLoader;
    private GlobalAttributeSender $globalAttributeSender;

    public function __construct(
        GlobalAttributeFileReader $globalAttributeLoader,
        GlobalAttributeSender $globalAttributeSender,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->globalAttributeLoader = $globalAttributeLoader;
        $this->globalAttributeSender = $globalAttributeSender;
    }

    protected function configure()
    {
        $this->setDescription('Import global attributes from marketplace and push to SCX')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                "Location of the JSON-File witch contains global attributes for this Marketplace",
                "./config/globalAttributes.json"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');
        $globalAttributeList = $this->globalAttributeLoader->read($filename);
        $output->writeln("Loaded {$globalAttributeList->count()} global Attributes");

        $this->globalAttributeSender->send($globalAttributeList);

        $output->writeln("Successfully send global Attributes to SCX");

        return 0;
    }
}
