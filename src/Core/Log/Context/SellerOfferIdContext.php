<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class SellerOfferIdContext implements ContextAware
{
    private string $sellerOfferId;

    public function __construct(string $sellerOfferId)
    {
        $this->sellerOfferId = $sellerOfferId;
    }

    public function __invoke(array $record): array
    {
        $record['sellerOfferId'] = $this->sellerOfferId;
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}