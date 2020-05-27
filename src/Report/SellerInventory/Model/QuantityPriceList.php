<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\Generic\GenericCollection;

class QuantityPriceList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(QuantityPrice::class);
    }

    public function toArray(): array
    {
        return array_map(function (QuantityPrice $item) {
            return $item->toArray();
        }, $this->itemList);
    }
}
