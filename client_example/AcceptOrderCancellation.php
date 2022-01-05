<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/12/21
 */

require_once __DIR__ . '/../vendor/autoload.php';

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Client\Api\Configuration;
use JTL\SCX\Lib\Channel\Client\Api\Order\OrderApi;
use JTL\SCX\Lib\Channel\Client\Api\Order\Request\AcceptCancellationRequest;

if (!isset($argv[1])) {
    throw new InvalidArgumentException("Provide a api refresh token as first argument");
}

if (!isset($argv[2])) {
    throw new InvalidArgumentException("Provide a sellerId");
}

if (!isset($argv[3])) {
    throw new InvalidArgumentException("Provide a orderCancellationRequestId");
}

$refreshToken = $argv[1];
$sellerId = $argv[2];
$orderCancellationRequestId = $argv[3];

$configuration = new Configuration(Configuration::HOST_PRODUCTION, $refreshToken);
$client = new AuthAwareApiClient($configuration);

$api = new OrderApi($client);

$request = new AcceptCancellationRequest($sellerId, $orderCancellationRequestId);
$response = $api->acceptOrderCancellation($request);
var_dump($response->isSuccessful());
