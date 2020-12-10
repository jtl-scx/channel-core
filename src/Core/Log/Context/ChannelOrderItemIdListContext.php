<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class ChannelOrderItemIdListContext implements ContextAware
{
    private array $channelOrderIdList;

    public function __construct(array $channelOrderIdList)
    {
        foreach ($channelOrderIdList as $channelOrderId) {
            $this->channelOrderIdList[] = (string)$channelOrderId;
        }
    }

    public function __invoke(array $record): array
    {
        $record['channelOrder']['itemIdList'] = $this->channelOrderIdList;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
