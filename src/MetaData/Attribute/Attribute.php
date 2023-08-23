<?php

declare(strict_types=1);
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
    private ?bool $recommended;
    private ?AttributeEnumValueList $values;
    private ?bool $isRepeatableSubSection;

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
        bool $isVariationDimension = null,
        bool $recommended = null,
        AttributeEnumValueList $values = null,
        bool $isRepeatableSubSection = null
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
        $this->recommended = $recommended;
        $this->values = $values;
        $this->isRepeatableSubSection = $isRepeatableSubSection;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function isMultipleAllowed(): bool
    {
        return $this->isMultipleAllowed;
    }

    public function getType(): AttributeType
    {
        return $this->type;
    }

    public function getEnumValues(): ?array
    {
        return $this->enumValues;
    }

    public function getAttributeValueValidation(): ?string
    {
        return $this->attributeValueValidation;
    }

    public function getConditionalMandatoryBy(): ?ConditionalAttributeList
    {
        return $this->conditionalMandatoryBy;
    }

    public function getConditionalOptionalBy(): ?ConditionalAttributeList
    {
        return $this->conditionalOptionalBy;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function getSubSection(): ?string
    {
        return $this->subSection;
    }

    public function getSubSectionPosition(): ?int
    {
        return $this->subSectionPosition;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSectionPosition(): ?int
    {
        return $this->sectionPosition;
    }

    public function isVariationDimension(): ?bool
    {
        return $this->isVariationDimension;
    }

    public function isRecommended(): ?bool
    {
        return $this->recommended;
    }

    public function getValues(): ?AttributeEnumValueList
    {
        return $this->values;
    }

    public function isRepeatableSubSection(): ?bool
    {
        return $this->isRepeatableSubSection;
    }
}
