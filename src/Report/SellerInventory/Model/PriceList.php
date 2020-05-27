<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\Generic\GenericCollection;

/**
 * Class PriceList
 * @package JTL\SCX\Lib\Channel\Report\SellerInventory\Model
 *
 * @method Price offsetGet($offset)
 */
class PriceList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(Price::class);
    }

    public function toArray(): array
    {
        return array_map(function (Price $item) {
            return $item->toArray();
        }, $this->itemList);
    }
}
