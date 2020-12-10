<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-12-08
 */

namespace JTL\SCX\Lib\Channel\Order;

use JTL\Generic\GenericCollection;

/**
 * Class OrderCancellationItemList
 * @package JTL\SCX\Channel\Real\Order\Model
 *
 * @method OrderCancellationItem offsetGet($offset)
 */
class OrderCancellationItemList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(OrderCancellationItem::class);
    }
}
