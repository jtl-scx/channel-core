<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-14
 */

namespace  JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\Generic\GenericCollection;

/**
 * Class InventoryItemList
 * @package JTL\SCX\Channel\Real\Report\SellerInventory\Model
 *
 * @method InventoryItem offsetGet($offset)
 */
class InventoryItemList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(InventoryItem::class);
    }

    public function toArray(): array
    {
        return array_map(function (InventoryItem $item) {
            return $item->toArray();
        }, $this->itemList);
    }
}
