<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\Generic\GenericCollection;
use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class QuantityPriceList extends GenericCollection
{
    use ToArrayTrait;

    public function __construct()
    {
        parent::__construct(QuantityPrice::class);
    }

    public function toArray(): array
    {
        return $this->createArray($this->itemList);
    }
}
