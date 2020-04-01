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
    private string $attributeId;
    private string $displayName;
    private bool $isMultipleAllowed;
    private AttributeType $type;
    private ?array $enumValues;
    private ?string $attributeValueValidation;
    private ?ConditionalAttributeList $conditionalMandatoryBy;
    private ?ConditionalAttributeList $conditionalOptionalBy;
    private bool $required;
    private ?string $section;
    private ?int $sectionPosition;
    private ?string $subSection;
    private ?int $subSectionPosition;
    private ?string $description;
    private ?bool $isVariationDimension;

    /**
     * Attribute constructor.
     * @param string $attributeId
     * @param string $displayName
     * @param string|null $description
     * @param bool $required
     * @param array|null $enumValues
     * @param AttributeType|null $type
     * @param bool $isMultipleAllowed
     * @param string|null $attributeValueValidation
     * @param ConditionalAttributeList|null $conditionalMandatoryBy
     * @param ConditionalAttributeList|null $conditionalOptionalBy
     * @param string|null $section
     * @param int|null $sectionPosition
     * @param string|null $subSection
     * @param int|null $subSectionPosition
     * @param bool|null $isVariationDimension
     */
    public function __construct(
        string $attributeId,
        string $displayName,
        string $description = null,
        bool $required = false,
        array $enumValues = null,
        AttributeType $type = null,
        bool $isMultipleAllowed = false,
        string $attributeValueValidation = null,
        ConditionalAttributeList $conditionalMandatoryBy = null,
        ConditionalAttributeList $conditionalOptionalBy = null,
        string $section = null,
        int $sectionPosition = null,
        string $subSection = null,
        int $subSectionPosition = null,
        bool $isVariationDimension = null
    ) {
        $this->attributeId = $attributeId;
        $this->displayName = $displayName;
        $this->description = $description;
        $this->required = $required;
        $this->enumValues = $enumValues;

        $type = $type ?? AttributeType::SMALLTEXT();
        $this->type = $type;

        $this->isMultipleAllowed = $isMultipleAllowed;
        $this->attributeValueValidation = $attributeValueValidation;
        $this->conditionalMandatoryBy = $conditionalMandatoryBy;
        $this->conditionalOptionalBy = $conditionalOptionalBy;
        $this->section = $section;
        $this->sectionPosition = $sectionPosition;
        $this->subSection = $subSection;
        $this->subSectionPosition = $subSectionPosition;
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
     * @return ConditionalAttributeList|null
     */
    public function getConditionalMandatoryBy(): ?ConditionalAttributeList
    {
        return $this->conditionalMandatoryBy;
    }

    /**
     * @return ConditionalAttributeList|null
     */
    public function getConditionalOptionalBy(): ?ConditionalAttributeList
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
