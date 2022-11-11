<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class ChannelOrderItemIdListContext extends LabeledContextAware
{
    private array $channelOrderIdList;

    public function __construct(array $channelOrderIdList)
    {
        foreach ($channelOrderIdList as $channelOrderId) {
            $this->channelOrderIdList[] = (string)$channelOrderId;
        }
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
                'itemIdList' => $this->channelOrderIdList,
            ],
        ];
    }
}
