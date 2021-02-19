<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 2/17/21
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class AttributeAllowedValue
{
    private string $value;
    private ?string $display;

    public function __construct(string $value, ?string $display)
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

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
