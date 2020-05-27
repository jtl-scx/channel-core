<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-08
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

class InventoryItem
{
    private ?int $sellerOfferId;
    private ?string $sku;
    private ?string $ean;
    private ?string $quantity;
    private ?PriceList $priceList;
    private ?string $title;
    private ?string $channelCategoryId;
    private ?array $channelAttributeList;
    private ?\DateTimeImmutable $createdAt;

    public function __construct(
        ?int $sellerOfferId,
        ?string $sku,
        ?string $ean,
        ?string $quantity,
        ?PriceList $priceList,
        ?string $title,
        ?string $channelCategoryId,
        ?array $channelAttributeList,
        \DateTimeImmutable $createdAt = null
    ) {
        $this->sellerOfferId = $sellerOfferId;
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

    public function getChannelAttributeList(): ?array
    {
        return $this->channelAttributeList;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $attr) {
            if (\is_object($attr)) {
                if ($attr instanceof \DateTimeImmutable) {
                    $data[$key] = $attr->format('c');
                } elseif (method_exists($attr, 'toArray')) {
                    $data[$key] = $attr->toArray();
                } else {
                    $data[$key] = get_object_vars($attr);
                }
            } else {
                $data[$key] = $attr;
            }
        }
        return $data;
    }
}
