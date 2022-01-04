<?php declare(strict_types=1);
/**
 * This script will demonstrate how to use the Channel API to upload an invoice document.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Client\Api\Configuration;
use JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\UploadInvoiceRequest;
use JTL\SCX\Lib\Channel\Client\Model\InvoiceMetaData;

if (!isset($argv[1])) {
    throw new InvalidArgumentException("Provide a api refresh token as first argument");
}

if (!isset($argv[2])) {
    throw new InvalidArgumentException("Provide the absolute path to a existing document");
}

if (!isset($argv[3])) {
    throw new InvalidArgumentException("Provide a sellerId");
}

if (!isset($argv[4])) {
    throw new InvalidArgumentException("Provide a orderId");
}

if (!isset($argv[5])) {
    throw new InvalidArgumentException("Provide a invoiceNumber");
}

$refreshToken = $argv[1];
$document = fopen($argv[2], 'r');
$sellerId = $argv[3];
$orderId = $argv[4];
$invoiceNumber = $argv[5];

$configuration = new Configuration(Configuration::HOST_PRODUCTION, $refreshToken);
$client = new AuthAwareApiClient($configuration);

$api = new OrderApi($client);

$meta = new InvoiceMetaData([
    'type' => 'INVOICE',
    'sellerId' => $sellerId,
    'orderId' => $orderId,
    'invoiceNumber' => $invoiceNumber,
]);
$response = $api->uploadInvoice(new UploadInvoiceRequest($meta, $document));
var_dump($response->isSuccessful());
