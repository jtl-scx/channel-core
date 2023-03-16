<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\OpsGenie\Client\HeartbeatApiClient;
use JTL\OpsGenie\Client\HttpClient;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;

class OpsGenieFactory
{
    public function __construct(private readonly Environment $environment)
    {
    }

    public function createHeartbeatClient(): HeartbeatApiClient
    {
        $client = HttpClient::createForEUApi($this->environment->get('OPSGENIE_TOKEN'));
        return new HeartbeatApiClient($client);
    }
}
