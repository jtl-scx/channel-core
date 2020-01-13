<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-16
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use Exception;
use JTL\SCX\Client\Channel\Api\Price\PriceApi;
use JTL\SCX\Client\Channel\Api\Price\Request\CreatePriceTypeRequest;
use JTL\SCX\Client\Channel\Model\PriceType;
use JTL\SCX\Lib\Channel\MetaData\Price\PriceTypeLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushPriceTypesCommand extends AbstractCommand
{
    protected static $defaultName = 'push:price-types';

    private PriceApi $client;
    private PriceTypeLoader $priceTypeLoader;

    public function __construct(PriceApi $client, PriceTypeLoader $priceTypeLoader)
    {
        $this->client = $client;

        parent::__construct();
        $this->priceTypeLoader = $priceTypeLoader;
    }

    protected function configure()
    {
        $this->addArgument(
            'filename',
            InputArgument::OPTIONAL,
            "Location of the JSON-File witch contains price definition for this Marketplace",
            "./config/priceDefinition.json"
        );
        $this->setDescription("Call to push all PriceTypes to SCX");
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $filename = $input->getArgument('filename');
        $priceTypes = $this->priceTypeLoader->load($filename);

        foreach ($priceTypes as $priceType) {
            $this->pushPrice($output, $priceType);
        }

        $output->writeln("Finished, pushed PriceTypes to SCX");
    }

    private function pushPrice(
        OutputInterface $output,
        PriceType $priceType
    ): void {
        $request = new CreatePriceTypeRequest($priceType);

        try {
            $response = $this->client->create($request);
        } catch (Exception $e) {
            $type = get_class($e);
            $output->writeln(
                "Error: POST /channel/price throwed a Exception ({$type}) with message:  '{$e->getMessage()}'."
            );
            return;
        }

        if ($response->getStatusCode() === 201) {
            $output->writeln("Pushed '{$priceType->getPriceTypeId()}' PriceType successful to SCX.");
        } else {
            $output->writeln("Error: POST /channel/price returned StatusCode '{$response->getStatusCode()}'.");
        }
    }
}
