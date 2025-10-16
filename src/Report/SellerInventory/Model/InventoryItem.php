<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-08
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class InventoryItem
{
    use ToArrayTrait;

    private ?int $sellerOfferId;
    private ?string $channelOfferId;
    private ?string $sku;
    private ?string $ean;
    private ?string $quantity;
    private ?PriceList $priceList;
    private ?string $title;
    private ?string $channelCategoryId;
    private ?ItemAttributeList $channelAttributeList;
    private ?\DateTimeImmutable $createdAt;

    public function __construct(
        ?int $sellerOfferId,
        ?string $channelOfferId,
        ?string $sku,
        ?string $ean,
        ?string $quantity,
        ?PriceList $priceList,
        ?string $title,
        ?string $channelCategoryId,
        ?ItemAttributeList $channelAttributeList,
        \DateTimeImmutable|null $createdAt = null
    ) {
        $this->sellerOfferId = $sellerOfferId;
        $this->channelOfferId = $channelOfferId;
        $this->sku = $sku;
        $this->ean = $ean;
        $this->quantity = $quantity;
        $this->priceList = $priceList;
        $this->title = $title;
        $this->channelCategoryId = $channelCategoryId;
        $this->channelAttributeList = $channelAttributeList;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getSellerOfferId(): ?int
    {
        return $this->sellerOfferId;
    }

    public function getChannelOfferId(): ?string
    {
        return $this->channelOfferId;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function getPriceList(): ?PriceList
    {
        return $this->priceList;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getChannelCategoryId(): ?string
    {
        return $this->channelCategoryId;
    }

    public function getChannelAttributeList(): ?ItemAttributeList
    {
        return $this->channelAttributeList;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
