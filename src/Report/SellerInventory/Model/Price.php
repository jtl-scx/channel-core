<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class Price
{
    use ToArrayTrait;

    private string $id;
    private QuantityPriceList $quantityPriceList;

    public function __construct(string $id, QuantityPriceList $quantityPriceList)
    {
        $this->id = $id;
        $this->quantityPriceList = $quantityPriceList;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuantityPriceList(): QuantityPriceList
    {
        return $this->quantityPriceList;
    }
}
