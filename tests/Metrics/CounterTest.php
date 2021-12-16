<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class CounterTest
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Metrics\Counter
 */
class CounterTest extends TestCase
{
    private Counter $sut;

    /**
     * @var \JTL\GoPrometrics\Client\Counter|\PHPUnit\Framework\MockObject\MockObject
     */
    private $counter;

    /**
     * @var Environment|\PHPUnit\Framework\MockObject\MockObject
     */
    private $environment;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LoggerInterface
     */
    private $logger;

    protected function setUp(): void
    {
        $this->counter = $this->createMock(\JTL\GoPrometrics\Client\Counter::class);
        $this->environment = $this->createMock(Environment::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->sut = new Counter($this->counter, $this->environment, $this->logger);
    }

    public function testItCanCountMetric()
    {
        $this->environment->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(['METRIC_COLLECTION_ENABLED'], ['CHANNEL_NAME'])
            ->willReturnOnConsecutiveCalls('1', 'FOO');


        $this->counter->expects($this->once())
            ->method('count');

        $this->sut->countKey('FOO');
    }

    public function testItWontCountIfDisabled()
    {
        $this->environment->expects($this->once())
            ->method('get')
            ->with('METRIC_COLLECTION_ENABLED')
            ->willReturn('0');


        $this->counter->expects($this->never())
            ->method('count');

        $this->sut->countKey('FOO');
    }
}
