<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/11/19
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

class Attribute
{
    /**
     * @var string
     */
    private $attributeId;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var bool
     */
    private $isMultipleAllowed;

    /**
     * @var AttributeType
     */
    private $type;

    /**
     * @var array|null
     */
    private $enumValues;

    /**
     * @var string|null
     */
    private $attributeValueValidation;

    /**
     * @var ConditionalAttributeCollection|null
     */
    private $conditionalMandatoryBy;

    /**
     * @var ConditionalAttributeCollection|null
     */
    private $conditionalOptionalBy;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var string|null
     */
    private $section;

    /**
     * @var int|null
     */
    private $sectionPosition;

    /**
     * @var string|null
     */
    private $subSection;

    /**
     * @var int|null
     */
    private $subSectionPosition;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var bool|null
     */
    private $isVariationDimension;

    /**
     * Attribute constructor.
     * @param string $attributeId
     * @param string $displayName
     * @param string|null $description
     * @param bool $required
     * @param array|null $enumValues
     * @param AttributeType $type
     * @param bool $isMultipleAllowed
     * @param string|null $attributeValueValidation
     * @param ConditionalAttributeCollection|null $conditionalMandatoryBy
     * @param ConditionalAttributeCollection|null $conditionalOptionalBy
     * @param string|null $section
     * @param int|null $sectionPosition
     * @param string|null $subSection
     * @param int|null $subSectionPosition
     * @param bool|null $isVariationDimension
     */
    public function __construct(
        string $attributeId,
        string $displayName,
        ?string $description,
        bool $required,
        ?array $enumValues,
        AttributeType $type,
        bool $isMultipleAllowed = false,
        string $attributeValueValidation = null,
        ConditionalAttributeCollection $conditionalMandatoryBy = null,
        ConditionalAttributeCollection $conditionalOptionalBy = null,
        string $section = null,
        int $sectionPosition = null,
        string $subSection = null,
        int $subSectionPosition = null,
        bool $isVariationDimension = null
    ) {
        $this->attributeId = $attributeId;
        $this->displayName = $displayName;
        $this->isMultipleAllowed = $isMultipleAllowed;
        $this->type = $type;
        $this->enumValues = $enumValues;
        $this->attributeValueValidation = $attributeValueValidation;
        $this->conditionalMandatoryBy = $conditionalMandatoryBy;
        $this->conditionalOptionalBy = $conditionalOptionalBy;
        $this->required = $required;
        $this->section = $section;
        $this->subSection = $subSection;
        $this->subSectionPosition = $subSectionPosition;
        $this->description = $description;
        $this->sectionPosition = $sectionPosition;
        $this->isVariationDimension = $isVariationDimension;
    }

    /**
     * @return string
     */
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return bool
     */
    public function isMultipleAllowed(): bool
    {
        return $this->isMultipleAllowed;
    }

    /**
     * @return AttributeType
     */
    public function getType(): AttributeType
    {
        return $this->type;
    }

    /**
     * @return array|null
     */
    public function getEnumValues(): ?array
    {
        return $this->enumValues;
    }

    /**
     * @return string|null
     */
    public function getAttributeValueValidation(): ?string
    {
        return $this->attributeValueValidation;
    }

    /**
     * @return ConditionalAttributeCollection|null
     */
    public function getConditionalMandatoryBy(): ?ConditionalAttributeCollection
    {
        return $this->conditionalMandatoryBy;
    }

    /**
     * @return ConditionalAttributeCollection|null
     */
    public function getConditionalOptionalBy(): ?ConditionalAttributeCollection
    {
        return $this->conditionalOptionalBy;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return string|null
     */
    public function getSection(): ?string
    {
        return $this->section;
    }

    /**
     * @return string|null
     */
    public function getSubSection(): ?string
    {
        return $this->subSection;
    }

    /**
     * @return int|null
     */
    public function getSubSectionPosition(): ?int
    {
        return $this->subSectionPosition;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $id
     * @return Attribute
     */
    public function setId(string $id): Attribute
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSectionPosition(): ?int
    {
        return $this->sectionPosition;
    }

    /**
     * @return bool|null
     */
    public function isVariationDimension(): ?bool
    {
        return $this->isVariationDimension;
    }
}
