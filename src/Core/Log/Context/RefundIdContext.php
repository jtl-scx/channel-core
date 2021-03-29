<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-29
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class RefundIdContext implements ContextAware
{
    private string $refundId;

    public function __construct(string $refundId)
    {
        $this->refundId = $refundId;
    }

    public function __invoke(array $record): array
    {
        $record['refundId'] = $this->refundId;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}