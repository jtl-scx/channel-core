<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class CounterTest
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Core\Metrics\Counter::class)]
class CounterTest extends TestCase
{
    private Counter $sut;

    /**
     * @var \JTL\GoPrometrics\Client\Counter|MockObject
     */
    private $counter;

    /**
     * @var Environment|MockObject
     */
    private $environment;

    /**
     * @var MockObject|LoggerInterface
     */
    private $logger;

    protected function setUp(): void
    {
        $this->counter = $this->createMock(\JTL\GoPrometrics\Client\Counter::class);
        $this->environment = $this->createMock(Environment::class);
        $this->logger = $this->createStub(LoggerInterface::class);

        $this->sut = new Counter($this->counter, $this->environment, $this->logger);
    }

    public function testItCanCountMetric()
    {
        $matcher = $this->exactly(2);
        $this->environment->expects($matcher)
            ->method('get')->willReturnCallback(function (...$parameters) use ($matcher) {
                if ($matcher->numberOfInvocations() === 1) {
                    $this->assertSame('METRIC_COLLECTION_ENABLED', $parameters[0]);
                    return '1';
                }
                if ($matcher->numberOfInvocations() === 2) {
                    $this->assertSame('CHANNEL_NAME', $parameters[0]);
                    return 'FOO';
                }
            });


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
