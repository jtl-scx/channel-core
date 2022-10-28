<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class ChannelOrderIdContext implements ContextAware
{
    private string $channelOrderId;

    public function __construct(string $channelOrderId)
    {
        $this->channelOrderId = $channelOrderId;
    }

    public function __invoke(array $record): array
    {
        $record['channelOrder']['id'] = $this->channelOrderId;
        $record['label'][] = 'channel';
        $record['label'][] = 'order';
        $record['label'] = array_unique($record['label']);
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
