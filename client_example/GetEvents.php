<?php declare(strict_types=1);

/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Client\Api\Configuration;
use JTL\SCX\Lib\Channel\Client\Api\Event\EventApi;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\GetEventListRequest;

require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($argv[1])) {
    throw new InvalidArgumentException("Provide a api refresh token as first argument");
}

$refreshToken = $argv[1];

$configuration = new Configuration(Configuration::HOST_PRODUCTION, $refreshToken);
$client = new AuthAwareApiClient($configuration);

$api = new EventApi($client);
$response = $api->get(new GetEventListRequest());
$eventIdList = [];

/** @var EventContainer $event */
foreach ($response->getEventList() as $key => $event) {
    echo sprintf(
        "%d\tEvent: %s (ID: %s; CreatedAt: %s)\n",
        $key,
        $event->getType()->getValue(),
        $event->getId(),
        $event->getCreatedAt()->format('c')
    );

    var_dump($event->getEvent());

    $eventIdList[] = $event->getId();
}

if (!empty($eventIdList)) {
    $response = $api->ack(new AcknowledgeEventIdListRequest($eventIdList));
    var_dump($response->isSuccessful());
}
