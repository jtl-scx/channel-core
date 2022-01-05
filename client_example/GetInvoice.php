<?php declare(strict_types=1);
/**
 * This script will demonstrate how to use the Channel API to receive an invoice document.
 * The demo script will store a copy of the document under /tmp folder
 */
require_once __DIR__ . '/../vendor/autoload.php';

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Client\Api\Configuration;
use JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\GetInvoiceRequest;

if (!isset($argv[1])) {
    throw new InvalidArgumentException("Provide a api refresh token as first argument");
}

if (!isset($argv[2])) {
    throw new InvalidArgumentException("Provide a documentId as second argument");
}

$refreshToken = $argv[1];
$documentId = $argv[2];

$configuration = new Configuration(Configuration::HOST_PRODUCTION, $refreshToken);
$client = new AuthAwareApiClient($configuration);

$api = new OrderApi($client);
$response = $api->getInvoice(new GetInvoiceRequest($documentId));

$localPath = "/tmp/scx_invoice_{$documentId}";
$content = $response->getDocument()->getContents();

var_dump([
    "successful" => $response->isSuccessful(),
    "documentBase64" => base64_encode($content),
    "documentLocation" => $localPath
]);

file_put_contents($localPath, $content);
