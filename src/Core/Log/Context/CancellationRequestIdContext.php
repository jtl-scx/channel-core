<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class CancellationRequestIdContext implements ContextAware
{
    private string $orderCancellationRequestId;

    public function __construct(string $orderCancellationRequestId)
    {
        $this->orderCancellationRequestId = $orderCancellationRequestId;
    }

    public function __invoke(array $record): array
    {
        $record['orderCancellationRequestId'] = $this->orderCancellationRequestId;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}