<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-10
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Core\ToArrayTrait;

class AttributeEnumValue
{
    use ToArrayTrait;

    private string $value;
    private ?string $display;

    public function __construct(string $value, string|null $display = null)
    {
        $this->value = $value;
        $this->display = $display;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDisplay(): ?string
    {
        return $this->display;
    }
}
