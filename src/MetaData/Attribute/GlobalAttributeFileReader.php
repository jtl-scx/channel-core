<?php declare(strict_types=1);
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

        if (!$this->validateDataList($attributeDataList)) {
            throw new InvalidArgumentException(
                "Could not decode json or json does not contain valid attribute-data."
            );
        }

        $attributeList = new AttributeList();
        foreach ($attributeDataList as $attributeData) {
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
                $enumValues = AttributeEnumValueList::fromArray($attributeData['values'] ?? []);
            }

            $attribute = new Attribute(
                $attributeData['attributeId'],
                $attributeData['displayName'],
                $attributeData['description'] ?? null,
                $attributeData['required'] ?? false,
                [],
                $type,
                $attributeData['isMultipleAllowed'] ?? false,
                $attributeData['attributeValueValidation'] ?? null,
                $conditionalMandatory,
                $conditionalOptional,
                $attributeData['section'] ?? null,
                $attributeData['sectionPosition'] ?? null,
                $attributeData['subSection'] ?? null,
                $attributeData['subSectionPosition'] ?? null,
                $attributeData['isVariationDimension'] ?? null,
                $attributeData['recommended'] ?? null,
                $enumValues
            );
            $attributeList[] = $attribute;
        }

        return $attributeList;
    }

    private function validateDataList($attribute): bool
    {
        if (!is_array($attribute) || empty($attribute)) {
            return false;
        }
        foreach ($attribute as $priceData) {
            if (!isset($priceData['attributeId']) || !isset($priceData['displayName'])) {
                return false;
            }
        }

        return true;
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
