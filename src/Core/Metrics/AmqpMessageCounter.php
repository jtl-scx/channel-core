<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use GuzzleHttp\Exception\GuzzleException;
use JTL\GoPrometrics\Client\Counter;
use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Contract\Message\MessageCounter;
use JTL\OpsGenie\Client\Heartbeat\PingRequest;
use JTL\OpsGenie\Client\HeartbeatApiClient;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use Psr\Log\LoggerInterface;

class AmqpMessageCounter implements MessageCounter
{
    public function __construct(
        private readonly Counter $counter,
        private readonly LoggerInterface $logger,
        private readonly HeartbeatApiClient $heartbeatApiClient,
        private readonly Environment $environment
    ) {
    }

    public function countMessage(Message $message): void
    {
        $labelList = new LabelList();
        $labelList->add(new Label('message', get_class($message)));
        $channelName = $this->environment->get('CHANNEL_NAME');

        if ($this->environment->get('OPSGENIE_ENABLED') === '1') {
            $heartbeatRate = (float)$this->environment->get('OPSGENIE_WORKER_HEARTBEAT_RATE');

            if (mt_rand() / mt_getrandmax() <= $heartbeatRate) {
                $this->heartbeatApiClient->sendPing(new PingRequest("SCX_{$channelName}_worker_heartbeat"));
            }
        }

        try {
            $this->counter->count('EA', 'messages_total', $labelList);
        } catch (GuzzleException $e) {
            $this->logger->error("Failed to collect metric 'messages_total': {$e->getMessage()}");
        }
    }
}
