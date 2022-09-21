<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/17/19
 */

namespace JTL\SCX\Lib\Channel\Client\Price;

use JTL\SCX\Lib\Channel\Client\Model\PriceContainer;
use JTL\SCX\Lib\Channel\Client\Model\QuantityPrice;

class PriceSelector
{
    public function priceContainerByType(array $priceList, PriceType $priceType): ?PriceContainer
    {
        foreach ($priceList as $priceContainer) {
            if ($priceContainer instanceof PriceContainer && $priceContainer->getId() === (string)$priceType) {
                return $priceContainer;
            }
        }
        return null;
    }

    public function minimumQuantityPriceByType(array $priceList, PriceType $priceType): ?QuantityPrice
    {
        $selectedPrice = null;
        $priceContainer = $this->priceContainerByType($priceList, $priceType);
        $priceList = [];
        if ($priceContainer instanceof PriceContainer) {
            $priceList = $priceContainer->getQuantityPriceList();
        }

        $startQuantity = 9999999999999;
        foreach ($priceList as $quantityPrice) {
            $quantity = (float)$quantityPrice->getQuantity();
            if ($quantity <= $startQuantity) {
                $selectedPrice = $quantityPrice;
                $startQuantity = $quantity;
            }
        }

        return $selectedPrice;
    }
}
