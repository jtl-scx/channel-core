<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class SellerOfferIdContext extends LabeledContextAware
{
    private int $sellerOfferId;

    public function __construct(int $sellerOfferId)
    {
        $this->sellerOfferId = $sellerOfferId;
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
        return ['sellerOfferId' => $this->sellerOfferId];
    }
}
