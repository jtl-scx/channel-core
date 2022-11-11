<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-29
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class RefundIdContext extends LabeledContextAware
{
    private string $refundId;

    public function __construct(string $refundId)
    {
        $this->refundId = $refundId;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [ContextLabel::refund];
    }

    protected function getLogContext(): array
    {
        return ['refundId' => $this->refundId];
    }
}
