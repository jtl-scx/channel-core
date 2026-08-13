<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use GuzzleHttp\Exception\GuzzleException;
use JTL\GoPrometrics\Client\Counter;
use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Contract\Message\MessageCounter;
use Psr\Log\LoggerInterface;

class AmqpMessageCounter implements MessageCounter
{
    public function __construct(
        private readonly Counter $counter,
        private readonly LoggerInterface $logger
    ) {
    }

    public function countMessage(Message $message): void
    {
        $labelList = new LabelList();
        $labelList->add(new Label('message', get_class($message)));

        try {
            $this->counter->count('EA', 'messages_total', $labelList);
        } catch (GuzzleException $e) {
            $this->logger->error("Failed to collect metric 'messages_total': {$e->getMessage()}");
        }
    }
}
