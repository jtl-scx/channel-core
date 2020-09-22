<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use Exception;
use JTL\SCX\Client\Channel\Api\Meta\Request\CreateShippingRulesRequest;
use JTL\SCX\Client\Channel\Api\Meta\ShippingRulesApi;
use JTL\SCX\Client\Channel\Model\ShippingRules;
use JTL\SCX\Client\Channel\Model\SupportedCarrier;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushShippingRulesCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.shipping-rules';

    private ShippingRulesApi $client;
    private FileHandler $fileHandler;

    public function __construct(ShippingRulesApi $client, FileHandler $fileHandler, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->client = $client;
        $this->fileHandler = $fileHandler;
    }

    protected function configure()
    {
        $this->addArgument(
            'filename',
            InputArgument::OPTIONAL,
            "Location of the JSON-File witch contains shipping group definition for this Marketplace",
            "./config/shippingGroups.json"
        );
        $this->setDescription("Call to push all ShippingGroups to SCX");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');

        if ($this->fileHandler->isFile($filename)) {
            $jsonData = json_decode($this->fileHandler->readContent($filename), true) ?? [] ;
            $supportedCarrierListData = [];
            if (isset($jsonData['supportedCarrierList'])) {
                $supportedCarrierListData = $jsonData['supportedCarrierList'];
            }
        } else {
            $output->writeln(
                "Error: {$filename} is not a file'."
            );
            return 1;
        }

        $supportedCarrierList = [];
        foreach ($supportedCarrierListData as $supportedCarrierData) {
            if (isset($supportedCarrierData['carrierId'], $supportedCarrierData['displayName'])) {
                $supportedCarrierList[] = new SupportedCarrier([
                    'carrierId' => $supportedCarrierData['carrierId'],
                    'displayName' => $supportedCarrierData['displayName']
                ]);
            }
        }

        if (count($supportedCarrierList) === 0) {
            $output->writeln(
                "Error: No valid carrier in input file."
            );
            return 2;
        }

        $shippingRules = new ShippingRules(['supportedCarrierList' => $supportedCarrierList]);
        $request = new CreateShippingRulesRequest($shippingRules);

        try {
            $response = $this->client->create($request);
        } catch (Exception $e) {
            $type = get_class($e);
            $output->writeln(
                "Error: Put shippung rules throwed a Exception ({$type}) with message:  '{$e->getMessage()}'."
            );
            return 3;
        }

        if ($response->isSuccessful()) {
            $output->writeln("Pushed '" . count($supportedCarrierList) . "' shipping rules successful to SCX.");
        } else {
            $output->writeln("Error: Put shippung rules returned StatusCode '{$response->getStatusCode()}'.");
            return 4;
        }

        return 0;
    }
}
