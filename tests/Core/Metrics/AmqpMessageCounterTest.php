<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 3/15/23
 */

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use GuzzleHttp\Exception\GuzzleException;
use JTL\GoPrometrics\Client\Counter;
use JTL\GoPrometrics\Client\LabelList;
use JTL\Nachricht\Contract\Message\Message;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class AmqpMessageCounter
 *
 * @package JTL\SCX\Lib\Channel\Core\Metrics
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Core\Metrics\AmqpMessageCounter::class)]
class AmqpMessageCounterTest extends TestCase
{
    #[Test]
    public function canCountMessage(): void
    {
        $gpCounter = $this->createMock(Counter::class);
        $logger = $this->createStub(LoggerInterface::class);

        $gpCounter->expects(self::once())
            ->method('count')
            ->with('EA', 'messages_total', self::isInstanceOf(LabelList::class));

        $counter = new AmqpMessageCounter($gpCounter, $logger);
        $counter->countMessage(new AmqpTestMessage());
    }

    #[Test]
    #[AllowMockObjectsWithoutExpectations]
    public function logsErrorWhenCountingFails(): void
    {
        $gpCounter = $this->createStub(Counter::class);
        $logger = $this->createMock(LoggerInterface::class);

        $gpCounter->method('count')->willThrowException($this->createMock(GuzzleException::class));
        $logger->expects(self::once())->method('error');

        $counter = new AmqpMessageCounter($gpCounter, $logger);
        $counter->countMessage(new AmqpTestMessage());
    }
}

class AmqpTestMessage implements Message
{
}
