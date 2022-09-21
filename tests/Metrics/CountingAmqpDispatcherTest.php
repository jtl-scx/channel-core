<?php

declare(strict_types=1);

namespace Core\Metrics;

use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Listener\ListenerProvider;
use JTL\SCX\Lib\Channel\Core\Metrics\CountingAmqpDispatcher;
use JTL\SCX\Lib\Channel\Core\Metrics\MessageCounter;
use PHPUnit\Framework\TestCase;

/**
 * Class CountingAmqpDispatcherTest
 * @package Core\Metrics
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Metrics\CountingAmqpDispatcher
 */
class CountingAmqpDispatcherTest extends TestCase
{
    private CountingAmqpDispatcher $sut;

    /**
     * @var MessageCounter|\PHPUnit\Framework\MockObject\MockObject
     */
    private $messageCounter;

    /**
     * @var ListenerProvider|\PHPUnit\Framework\MockObject\MockObject
     */
    private $listenerProvider;

    protected function setUp(): void
    {
        $this->messageCounter = $this->createMock(MessageCounter::class);
        $this->listenerProvider = $this->createMock(ListenerProvider::class);

        $this->sut = new CountingAmqpDispatcher($this->listenerProvider, $this->messageCounter);
    }


    public function testDispatch()
    {
        $message = $this->createMock(Message::class);
        $this->messageCounter->expects($this->once())
            ->method('countMessage')
            ->with($message);

        $this->listenerProvider->method('getListenersForMessage')
            ->willReturn([]);

        $this->sut->dispatch($message);
    }
}
