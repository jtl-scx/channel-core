<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class CategoryAttribute
{
    /**
     * @var int
     */
    private $attributeId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    private $isMultipleAllowed;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $required;

    /**
     * CategoryAttribute constructor.
     * @param int $attributeId
     * @param string $name
     * @param string $title
     * @param bool $isMultipleAllowed
     * @param string $type
     * @param bool $required
     */
    public function __construct(
        int $attributeId,
        string $name,
        string $title,
        bool $isMultipleAllowed,
        string $type,
        bool $required
    ) {
        $this->attributeId = $attributeId;
        $this->name = $name;
        $this->title = $title;
        $this->isMultipleAllowed = $isMultipleAllowed;
        $this->type = $type;
        $this->required = $required;
    }

    /**
     * @return int
     */
    public function getAttributeId(): int
    {
        return $this->attributeId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isMultipleAllowed(): bool
    {
        return $this->isMultipleAllowed;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}
