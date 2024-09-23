<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class MessageFQNContext implements ContextAware
{
    public function __construct(private readonly string $messageClass)
    {
    }

    public function __invoke(array $record): array
    {
        $record['extra']['messageFQN'] = $this->messageClass;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
