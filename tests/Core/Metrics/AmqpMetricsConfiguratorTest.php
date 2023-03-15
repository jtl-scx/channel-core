<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\GoPrometrics\Client\LabelList;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;

/**
 * Class AmqpMetricsConfigurator
 *
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Metrics\AmqpMetricsConfigurator
 */
class AmqpMetricsConfiguratorTest extends TestCase
{
    /**
     * @test
     */
    public function canConfigureMetrics(): void
    {
        $channelName = uniqid('channelName', true);
        $labelList = new LabelList();

        $environment = $this->createMock(Environment::class);

        $environment->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive(['CHANNEL_NAME'], ['METRIC_COLLECTION_ENABLED'])
            ->willReturnOnConsecutiveCalls($channelName, '1');

        $configurator = new AmqpMetricsConfigurator($environment);
        $newLabelList = $configurator->extendLabelList($labelList);

        self::assertEquals(1, $newLabelList->count());
        self::assertEquals('channel', $newLabelList[0]->getKey());
        self::assertEquals($channelName, $newLabelList[0]->getValue());
        self::assertTrue($configurator->isActive());
    }
}
