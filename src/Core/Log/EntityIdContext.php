<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/13/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class EntityIdContext implements ContextAware
{
    private string $entityId;

    public function __construct(string $entityId)
    {
        $this->entityId = $entityId;
    }

    public function __invoke(array $record): array
    {
        $record['entityId'] = $this->entityId;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
