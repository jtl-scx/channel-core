<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class CancellationRequestIdContext extends LabeledContextAware
{
    private string $orderCancellationRequestId;

    public function __construct(string $orderCancellationRequestId)
    {
        $this->orderCancellationRequestId = $orderCancellationRequestId;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [ContextLabel::cancellation];
    }

    protected function getLogContext(): array
    {
        return ['orderCancellationRequestId' => $this->orderCancellationRequestId];
    }
}
