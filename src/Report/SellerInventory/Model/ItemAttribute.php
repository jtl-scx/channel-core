<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Model;

use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class ItemAttribute
{
    use ToArrayTrait;

    private string $attributeId;
    private string $value;

    public function __construct(string $attributeId, string $value)
    {
        $this->attributeId = $attributeId;
        $this->value = $value;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
