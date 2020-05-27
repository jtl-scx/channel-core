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

    public static function fromArray(array $data): PriceList
    {
        $priceList = new self();
        foreach ($data as $price) {
            $quantityPriceList = new QuantityPriceList();
            foreach ($price['quantityPriceList'] ?? [] as $quantityPriceData) {
                $quantityPriceList->add(new QuantityPrice(
                    (string)$quantityPriceData['amount'],
                    (string)$quantityPriceData['currency'],
                    (string)$quantityPriceData['quantity']
                ));
            }
            $priceList->add(new Price($price['id'], $quantityPriceList));
        }

        return $priceList;
    }

    public function toArray(): array
    {
        return array_map(function (Price $item) {
            return $item->toArray();
        }, $this->itemList);
    }
}
