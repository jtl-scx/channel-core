<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Seller;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerIdContext;

class ChannelSellerId implements ContextAware
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
        return new SellerIdContext($this);
    }
}
