<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 8/10/21
 */

namespace JTL\SCX\Lib\Channel\Core\RabbitMqManagementApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JTL\Nachricht\Transport\Amqp\AmqpConnectionSettings;
use JTL\Nachricht\Transport\Amqp\AmqpHttpConnectionFailedException;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/**
 * Class RabbitMqQueueLister
 *
 * @package JTL\SCX\Lib\Channel\Core\RabbitMqManagementApi
 *
 * @covers \JTL\SCX\Lib\Channel\Core\RabbitMqManagementApi\RabbitMqQueueLister
 */
class RabbitMqQueueListerTest extends TestCase
{
    private AmqpTransport $transport;
    private Client $client;
    private RabbitMqQueueLister $lister;
    private AmqpConnectionSettings $connectionSettings;

    protected function setUp(): void
    {
        $this->transport = $this->createMock(AmqpTransport::class);
        $this->client = $this->createMock(Client::class);
        $this->lister = new RabbitMqQueueLister($this->transport, $this->client);
        $this->connectionSettings = $this->createMock(AmqpConnectionSettings::class);
    }

    /**
     * @test
     */
    public function canListQueues(): void
    {
        $host = uniqid('host', true);
        $port = (string)random_int(1025, 100000);
        $username = uniqid('username', true);
        $password = uniqid('password', true);
        $responseString = '[{"name": "queue1"}, {"name": "queue2"}]';

        $response = $this->createMock(Response::class);
        $responseBody = $this->createMock(StreamInterface::class);

        $this->transport->expects(self::once())
            ->method('getConnectionSettings')
            ->willReturn($this->connectionSettings);

        $this->connectionSettings->expects(self::once())
            ->method('getHost')
            ->willReturn($host);

        $this->connectionSettings->expects(self::once())
            ->method('getHttpPort')
            ->willReturn($port);

        $this->connectionSettings->expects(self::once())
            ->method('getUser')
            ->willReturn($username);

        $this->connectionSettings->expects(self::once())
            ->method('getPassword')
            ->willReturn($password);

        $this->client->expects(self::once())
            ->method('request')
            ->with(
                'GET',
                "{$host}:{$port}/api/queues",
                ['auth' => [$username, $password]]
            )
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($responseBody);

        $responseBody->expects(self::once())
            ->method('getContents')
            ->willReturn($responseString);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(200);

        $result = $this->lister->listQueues();
        self::assertEquals(['queue1', 'queue2'], $result);
    }

    /**
     * @test
     */
    public function failListQueuesIfStatusCodeIsNot200(): void
    {
        $host = uniqid('host', true);
        $port = (string)random_int(1025, 100000);
        $username = uniqid('username', true);
        $password = uniqid('password', true);

        $response = $this->createMock(Response::class);

        $this->transport->expects(self::once())
            ->method('getConnectionSettings')
            ->willReturn($this->connectionSettings);

        $this->connectionSettings->expects(self::once())
            ->method('getHost')
            ->willReturn($host);

        $this->connectionSettings->expects(self::once())
            ->method('getHttpPort')
            ->willReturn($port);

        $this->connectionSettings->expects(self::once())
            ->method('getUser')
            ->willReturn($username);

        $this->connectionSettings->expects(self::once())
            ->method('getPassword')
            ->willReturn($password);

        $this->client->expects(self::once())
            ->method('request')
            ->with(
                'GET',
                "{$host}:{$port}/api/queues",
                ['auth' => [$username, $password]]
            )
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $response->expects(self::once())
            ->method('getReasonPhrase')
            ->willReturn('');

        $this->expectException(AmqpHttpConnectionFailedException::class);
        $this->lister->listQueues();
    }
}
