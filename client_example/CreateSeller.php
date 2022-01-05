<?php declare(strict_types=1);
/**
 * This script will demonstrate how to use the Channel API to create a Seller
 */
require_once __DIR__ . '/../vendor/autoload.php';

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Client\Api\Configuration;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\CreateSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\SellerApi;

if (!isset($argv[1])) {
    throw new InvalidArgumentException("Provide a api refresh token as first argument");
}

if (!isset($argv[2])) {
    throw new InvalidArgumentException("Provide signup sessionId");
}

if (!isset($argv[3])) {
    throw new InvalidArgumentException("Provide a sellerId");
}

$refreshToken = $argv[1];
$signupSessionId = $argv[2];
$sellerId = $argv[3];

$configuration = new Configuration(Configuration::HOST_PRODUCTION, $refreshToken);
$client = new AuthAwareApiClient($configuration);

$api = new SellerApi($client);

// optional step to receive the JTLAccountId
$signupSessionData = $api->getSignupSessionData($signupSessionId);
var_dump($signupSessionData);
printf("Signup Session belongs to jtlAccountId = %s\n", $signupSessionData->getJtlAccountId());

$response = $api->create(CreateSellerRequest::make($sellerId, $signupSessionId));
var_dump($response);
echo "Seller successful created\n";

// export T=CHAN.***
// export SES=***
// php client_example/CreateSeller.php $T $SES 1
