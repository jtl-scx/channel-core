<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class ChannelOrderIdContext extends LabeledContextAware
{
    private string $channelOrderId;

    public function __construct(string $channelOrderId)
    {
        $this->channelOrderId = $channelOrderId;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [
            ContextLabel::channel,
            ContextLabel::order,
        ];
    }

    protected function getLogContext(): array
    {
        return [
            'channelOrder' => [
                'id' => $this->channelOrderId,
            ],
        ];
    }
}
