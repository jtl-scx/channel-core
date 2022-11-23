<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Seller;

use JTL\SCX\Lib\Channel\Core\Log\Context\ContextLabel;
use JTL\SCX\Lib\Channel\Core\Log\Context\LabeledContextAware;

class ChannelSellerId extends LabeledContextAware
{
    private string $sellerId;

    public function __construct(string $sellerId)
    {
        $this->sellerId = $sellerId;
    }

    public function getId(): string
    {
        return $this->sellerId;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [ContextLabel::seller];
    }

    protected function getLogContext(): array
    {
        return [
            'seller' => [
                'id' => $this->sellerId
            ]
        ];
    }
}
