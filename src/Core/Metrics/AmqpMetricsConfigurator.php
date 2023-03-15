<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/10/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\GoPrometrics\Client\GoPometricsConfigurator;
use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;

class AmqpMetricsConfigurator implements GoPometricsConfigurator
{
    public function __construct(private readonly Environment $environment)
    {
    }

    public function extendLabelList(LabelList $labelList): LabelList
    {
        $channelName = $this->environment->get('CHANNEL_NAME');

        $labelList->add(new Label('channel', $channelName));
        return $labelList;
    }

    public function isActive(): bool
    {
        return $this->environment->get('METRIC_COLLECTION_ENABLED') === '1';
    }
}
