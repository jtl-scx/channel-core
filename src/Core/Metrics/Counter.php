<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use Exception;
use JTL\GoPrometrics\Client\Counter as GoPrometricsCounter;
use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use Psr\Log\LoggerInterface;

class Counter
{
    private GoPrometricsCounter $counter;
    private Environment $environment;
    private LoggerInterface $logger;

    public function __construct(
        GoPrometricsCounter $counter,
        Environment $environment,
        LoggerInterface $logger
    ) {
        $this->counter = $counter;
        $this->environment = $environment;
        $this->logger = $logger;
    }

    public function countKey(string $key, LabelList|null $labelList = null): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        if ($labelList === null) {
            $labelList = new LabelList();
        }

        try {
            $channelName = $this->environment->get('CHANNEL_NAME');

            $labelList->add(new Label('channel', $channelName));
            $this->counter->count('EA', $key, $labelList);
        } catch (Exception $exception) {
            $this->logger->error("Failed to collect metric {$key}: {$exception->getMessage()}");
        }
    }

    private function isEnabled(): bool
    {
        return $this->environment->get('METRIC_COLLECTION_ENABLED') === '1';
    }
}
