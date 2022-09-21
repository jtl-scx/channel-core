<?php

declare(strict_types=1);

namespace Core\Metrics;

use JTL\Nachricht\Contract\Message\Message;
use JTL\SCX\Lib\Channel\Core\Metrics\Counter;
use JTL\SCX\Lib\Channel\Core\Metrics\MessageCounter;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageCounterTest
 * @package Core\Metrics
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Metrics\MessageCounter
 */
class MessageCounterTest extends TestCase
{
    public function testCanCountMessage()
    {
        $counter = $this->createMock(Counter::class);
        $messageCounter = new MessageCounter($counter);

        $message = $this->createMock(Message::class);
        $counter->expects($this->once())
            ->method('countKey');

        $messageCounter->countMessage($message);
    }
}
