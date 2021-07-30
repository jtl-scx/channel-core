<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 7/27/21
 */

namespace JTL\SCX\Lib\Channel\Core\Amqp;

use JsonException;
use JTL\Nachricht\Contract\Transport\Amqp\AmqpQueueLister;
use JTL\Nachricht\Transport\Amqp\AmqpHttpConnectionFailedException;
use JTL\Nachricht\Transport\Amqp\AmqpTransport;

class RabbitMqQueueLister implements AmqpQueueLister
{
    private AmqpTransport $transport;

    public function __construct(AmqpTransport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @throws AmqpHttpConnectionFailedException
     * @throws JsonException
     */
    public function listQueues(string $queuePrefix = null): array
    {
        $con = $this->transport->getConnectionSettings();
        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, [
            CURLOPT_URL => $con->getHost() . '/api/queues',
            CURLOPT_PORT => (int)$con->getHttpPort(),
            CURLOPT_USERNAME => $con->getUser(),
            CURLOPT_PASSWORD => $con->getPassword(),
            CURLOPT_RETURNTRANSFER => true
        ]);
        $result = curl_exec($curlHandle);
        $errorCode = curl_errno($curlHandle);
        $errorString = curl_error($curlHandle);
        curl_close($curlHandle);

        if ($errorCode !== 0) {
            throw new AmqpHttpConnectionFailedException($errorString, $errorCode);
        }

        $channelData = json_decode($result, true, 512, JSON_THROW_ON_ERROR);
        $channelList = array_map(static fn (array $data) => $data['name'], $channelData);

        if ($queuePrefix === null) {
            return $channelList;
        }

        return array_filter($channelList, static fn ($name) => strpos($name, $queuePrefix) === 0);
    }
}
