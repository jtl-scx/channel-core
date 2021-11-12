<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use Exception;
use JTL\SCX\Lib\Channel\Client\Api\Meta\PaymentRulesApi;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreatePaymentRulesRequest;
use JTL\SCX\Lib\Channel\Client\Model\PaymentRules;
use JTL\SCX\Lib\Channel\Client\Model\SupportedPaymentMethod;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushPaymentRulesCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:put.payment-rules';

    private PaymentRulesApi $client;
    private FileHandler $fileHandler;

    public function __construct(PaymentRulesApi $client, FileHandler $fileHandler, ScxLogger $logger)
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
            "Location of the JSON-File witch contains payment rule definition for this Marketplace",
            "./config/paymentRules.json"
        );
        $this->setDescription("Call to push all PaymentRules to SCX");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');

        if ($this->fileHandler->isFile($filename)) {
            $jsonData = json_decode($this->fileHandler->readContent($filename), true) ?? [] ;
            $supportedPaymentListData = [];
            if (isset($jsonData['supportedPaymentMethodList'])) {
                $supportedPaymentListData = $jsonData['supportedPaymentMethodList'];
            }
        } else {
            $output->writeln(
                "Error: {$filename} is not a file'."
            );
            return 1;
        }

        $supportedPaymentMethodList = [];
        foreach ($supportedPaymentListData as $supportedPaymentData) {
            if (isset($supportedPaymentData['paymentMethodId'], $supportedPaymentData['displayName'])) {
                $supportedPaymentMethodList[] = new SupportedPaymentMethod([
                    'paymentMethodId' => $supportedPaymentData['paymentMethodId'],
                    'displayName' => $supportedPaymentData['displayName'],
                ]);
            }
        }
        $paymentRules = new PaymentRules(['supportedPaymentMethodList' => $supportedPaymentMethodList]);
        $request = new CreatePaymentRulesRequest($paymentRules);

        if (count($supportedPaymentMethodList) === 0) {
            $output->writeln(
                "Error: No valid payment rule in input file."
            );
            return 2;
        }
        try {
            $response = $this->client->create($request);
        } catch (Exception $e) {
            $type = get_class($e);
            $output->writeln(
                "Error: Put payment rules throwed a Exception ({$type}) with message:  '{$e->getMessage()}'."
            );
            return 3;
        }

        if ($response->isSuccessful()) {
            $output->writeln("Pushed '" . count($supportedPaymentMethodList) . "' payment rules successful to SCX.");
        } else {
            $output->writeln("Error: Put payment rules returned StatusCode '{$response->getStatusCode()}'.");
            return 4;
        }

        return 0;
    }
}
