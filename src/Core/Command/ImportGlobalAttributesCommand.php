<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateGlobalAttributesRequest;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeMapper;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportGlobalAttributesCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.attributes-global';

    private GlobalAttributeLoader $globalAttributeLoader;
    private AttributesApi $client;
    private AttributeMapper $attributeMapper;

    public function __construct(
        AttributesApi $client,
        GlobalAttributeLoader $globalAttributeLoader,
        AttributeMapper $attributeMapper,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->globalAttributeLoader = $globalAttributeLoader;
        $this->client = $client;
        $this->attributeMapper = $attributeMapper;
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
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $filename = $input->getArgument('filename');
        $globalAttributeList = $this->globalAttributeLoader->load($filename);
        $output->writeln("Loaded {$globalAttributeList->count()} global Attributes");

        $attributeList = new ClientAttributeList();
        $attributeList->setAttributeList($this->attributeMapper->map($globalAttributeList));
        $request = new CreateGlobalAttributesRequest($attributeList);
        $output->writeln("CreateGlobalAttributesRequest created");

        $this->client->createGlobalAttributes($request);
        $output->writeln("Successfully send global Attributes to SCX");
    }
}
