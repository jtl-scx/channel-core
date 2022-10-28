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

class ChannelOfferIdContext implements ContextAware
{
    private string $channelOfferId;

    public function __construct(string $channelOfferId)
    {
        $this->channelOfferId = $channelOfferId;
    }

    public function __invoke(array $record): array
    {
        $record['channelOffer']['id'] = $this->channelOfferId;
        $record['label'][] = 'offer';
        $record['label'] = array_unique($record['label']);
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
