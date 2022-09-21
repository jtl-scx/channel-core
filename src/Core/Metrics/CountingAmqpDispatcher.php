<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\Nachricht\Contract\Message\Message;
use JTL\Nachricht\Dispatcher\AmqpDispatcher;
use JTL\Nachricht\Listener\ListenerProvider;

class CountingAmqpDispatcher extends AmqpDispatcher
{
    private MessageCounter $messageCounter;

    public function __construct(ListenerProvider $listenerProvider, MessageCounter $messageCounter)
    {
        parent::__construct($listenerProvider);
        $this->messageCounter = $messageCounter;
    }

    public function dispatch(object $message): void
    {
        if ($message instanceof Message) {
            $this->messageCounter->countMessage($message);
        }

        parent::dispatch($message);
    }
}
