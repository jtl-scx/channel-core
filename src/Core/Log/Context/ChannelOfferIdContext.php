<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class ChannelOfferIdContext extends LabeledContextAware
{
    private string $channelOfferId;

    public function __construct(string $channelOfferId)
    {
        $this->channelOfferId = $channelOfferId;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [ContextLabel::offer];
    }

    protected function getLogContext(): array
    {
        return [
            'channelOffer' => [
                'id' => $this->channelOfferId,
            ],
        ];
    }
}
