<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 7/27/21
 */

namespace JTL\SCX\Lib\Channel\Core\RabbitMqManagementApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use JTL\Nachricht\Contract\Transport\Amqp\AmqpQueueLister;
use JTL\Nachricht\Transport\Amqp\AmqpHttpConnectionFailedException;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;

class RabbitMqQueueLister implements AmqpQueueLister
{
    private AmqpTransport $transport;
    private Client $client;

    public function __construct(AmqpTransport $transport, Client $client)
    {
        $this->transport = $transport;
        $this->client = $client;
    }

    /**
     * @throws AmqpHttpConnectionFailedException
     * @throws JsonException
     * @throws GuzzleException
     * @return array<int, string>
     */
    public function listQueues(string $queuePrefix = null): array
    {
        $con = $this->transport->getConnectionSettings();
        $url = $con->getHost();

        if (substr_compare($url, '/', -1) === 0) {
            $url = substr($url, 0, -1);
        }

        $url .= ":{$con->getHttpPort()}/api/queues";
        $response = $this->client->request(
            'GET',
            $url,
            [
                'auth' => [$con->getUser(), $con->getPassword()],
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw new AmqpHttpConnectionFailedException($response->getReasonPhrase());
        }

        $result = $response->getBody()->getContents();
        $channelData = json_decode($result, true, 512, JSON_THROW_ON_ERROR);
        $channelList = array_map(static fn (array $data) => $data['name'], $channelData);

        if ($queuePrefix === null) {
            return $channelList;
        }

        return array_filter($channelList, static fn ($name) => strpos($name, $queuePrefix) === 0);
    }
}
