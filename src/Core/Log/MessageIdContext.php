<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class MessageIdContext implements ContextAware
{
    private string $messageId;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    public function __invoke(array $record): array
    {
        $record['messageId'] = $this->messageId;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
