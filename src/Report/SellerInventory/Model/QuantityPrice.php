<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

class QuantityPrice
{
    private string $price;
    private string $currency;
    private string $quantity;

    public function __construct(string $price, string $currency, string $quantity = '1.0')
    {
        $this->price = $price;
        $this->currency = $currency;
        $this->quantity = $quantity;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
