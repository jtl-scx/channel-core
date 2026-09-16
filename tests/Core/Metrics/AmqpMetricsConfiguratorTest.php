<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\GoPrometrics\Client\Label;
use JTL\GoPrometrics\Client\LabelList;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;

/**
 * Class AmqpMetricsConfigurator
 *
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Core\Metrics\AmqpMetricsConfigurator::class)]
class AmqpMetricsConfiguratorTest extends TestCase
{
    #[Test]
    public function canConfigureMetrics(): void
    {
        $channelName = uniqid('channelName', true);
        $labelList = new LabelList();

        $environment = $this->createMock(Environment::class);
        $environment->expects(self::exactly(2))
            ->method('get')
            ->willReturnCallback(static fn (string $key): string => match ($key) {
                'CHANNEL_NAME' => $channelName,
                'METRIC_COLLECTION_ENABLED' => '1',
            });

        $configurator = new AmqpMetricsConfigurator($environment);
        $newLabelList = $configurator->extendLabelList($labelList);

        self::assertEquals(1, $newLabelList->count());
        self::assertEquals('channel', $newLabelList[0]->getKey());
        self::assertEquals($channelName, $newLabelList[0]->getValue());
        self::assertTrue($configurator->isActive());
    }

    #[Test]
    public function it_will_not_extend_channel_label_when_already_exist(): void
    {
        $labelList = new LabelList();
        $labelList->add(new Label('channel', 'ANY_CHANNEL'));

        $environment = new Environment(['channel' => 'ENV_CHANNEL']);

        $configurator = new AmqpMetricsConfigurator($environment);
        $newLabelList = $configurator->extendLabelList($labelList);

        self::assertEquals(1, $newLabelList->count());
        self::assertEquals('ANY_CHANNEL', $newLabelList[0]->getValue());
    }


}
