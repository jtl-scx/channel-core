<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JTL\GoPrometrics\Client\Counter;
use JTL\Nachricht\Contract\Message\Message;
use JTL\OpsGenie\Client\HeartbeatApiClient;
use JTL\OpsGenie\Client\HttpClient;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class AmqpMessageCounter
 *
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Metrics\AmqpMessageCounter
 */
class AmqpMessageCounterTest extends TestCase
{
    /**
     * @test
     */
    public function canCountMessage(): void
    {
        $message = new AmqpTestMessage();
        $channelName = uniqid('channelName', true);

        $gpCounter = $this->createMock(Counter::class);
        $logger = $this->createMock(LoggerInterface::class);
        $guzzle = $this->createMock(Client::class);
        $httpClient = new HttpClient('abc', $guzzle);
        $heartbeat = new HeartbeatApiClient($httpClient);
        $environment = $this->createMock(Environment::class);
        $counter = new AmqpMessageCounter($gpCounter, $logger, $heartbeat, $environment);
        $heartbeatResponse = new Response(body: '{}');

        $environment->expects(self::exactly(3))
            ->method('get')
            ->withConsecutive(['CHANNEL_NAME'], ['OPSGENIE_ENABLED'], ['OPSGENIE_WORKER_HEARTBEAT_RATE'])
            ->willReturnOnConsecutiveCalls($channelName, '1', '1');

        $guzzle->expects(self::once())
            ->method('request')
            ->with('PUT', "heartbeats/SCX_{$channelName}_worker_heartbeat/ping", [
                'headers' => [
                    'Authorization' => 'GenieKey abc',
                    'Content-Type' => 'application/json',
                ],
                'body' => '{}',
            ])
            ->willReturn($heartbeatResponse);

        $counter->countMessage($message);
    }
}

class AmqpTestMessage implements Message
{
}
