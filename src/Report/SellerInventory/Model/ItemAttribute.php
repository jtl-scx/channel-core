<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class ItemAttribute
{
    use ToArrayTrait;

    public function __construct(
        private readonly string $attributeId,
        private readonly string $value,
        private readonly ?string $group = null
    ) {
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }
}
