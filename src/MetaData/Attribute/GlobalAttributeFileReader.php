<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-30
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use InvalidArgumentException;
use JsonException;
use JTL\SCX\Lib\Channel\Helper\FileHandler;

class GlobalAttributeFileReader
{
    private FileHandler $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param string $filename
     * @return AttributeList
     * @throws JsonException
     */
    public function read(string $filename): AttributeList
    {
        if (!$this->fileHandler->isFile($filename)) {
            throw new InvalidArgumentException("{$filename} is not a valid file");
        }

        $attributeJson = $this->fileHandler->readContent($filename);
        $attributeDataList = json_decode($attributeJson, true, 512, JSON_THROW_ON_ERROR);

        $attributeList = new AttributeList();
        foreach ($attributeDataList ?? [] as $attributeData) {
            $attributeId = $attributeData['attributeId'] ?? null;
            $displayName = $attributeData['displayName'] ?? null;
            if ($attributeId === null || $displayName === null) {
                throw new InvalidArgumentException("Invalid attribute schema. There has to be a attributeId and displayName");
            }

            $conditionalMandatory = $this->createConditionalAttributeCollection(
                $attributeData['conditionalMandatoryBy'] ?? null
            );
            $conditionalOptional = $this->createConditionalAttributeCollection(
                $attributeData['conditionalOptionalBy'] ?? null
            );

            $type = AttributeType::SMALLTEXT();
            if (isset($attributeData['type'])) {
                $type = new AttributeType($attributeData['type']);
            }

            $enumValues = null;
            if ($type->equals(AttributeType::ENUM())) {
                if (isset($attributeData['values'])) {
                    $enumValues = AttributeEnumValueList::fromArray($attributeData['values']);
                } elseif (isset($attributeData['enumValues'])) {
                    $enumValues = AttributeEnumValueList::fromScalarArray($attributeData['enumValues']);
                } else {
                    $enumValues = new AttributeEnumValueList();
                }
            }

            $attribute = new Attribute(
                attributeId: $attributeData['attributeId'],
                displayName: $attributeData['displayName'],
                description: $attributeData['description'] ?? null,
                required: $attributeData['required'] ?? false,
                enumValues: null,
                type: $type,
                isMultipleAllowed: $attributeData['isMultipleAllowed'] ?? false,
                attributeValueValidation: $attributeData['attributeValueValidation'] ?? null,
                conditionalMandatoryBy: $conditionalMandatory,
                conditionalOptionalBy: $conditionalOptional,
                section: $attributeData['section'] ?? null,
                sectionPosition: $attributeData['sectionPosition'] ?? null,
                subSection: $attributeData['subSection'] ?? null,
                subSectionPosition: $attributeData['subSectionPosition'] ?? null,
                isVariationDimension: $attributeData['isVariationDimension'] ?? null,
                recommended: $attributeData['recommended'] ?? null,
                values: $enumValues,
                isRepeatableSubSection: $attributeData['isRepeatableSubSection'] ?? false
            );
            $attributeList[] = $attribute;
        }

        return $attributeList;
    }

    private function createConditionalAttributeCollection(?array $conditionalByList): ?ConditionalAttributeList
    {
        if ($conditionalByList === null) {
            return null;
        }
        $conditionalAttributeCollection = new ConditionalAttributeList();

        foreach ($conditionalByList as $conditionalBy) {
            if (!isset($conditionalBy['attributeId']) || empty($conditionalBy['attributeId'])) {
                throw new InvalidArgumentException("For conditional attributes a 'attributeId' is required");
            }

            if (!isset($conditionalBy['attributeValues']) || !is_array($conditionalBy['attributeValues'])) {
                throw new InvalidArgumentException(
                    "For conditional attributes 'attributeValues' has to be an array"
                );
            }

            $conditionalAttributeCollection->add(
                new ConditionalAttribute($conditionalBy['attributeId'], $conditionalBy['attributeValues'])
            );
        }

        return $conditionalAttributeCollection;
    }
}
