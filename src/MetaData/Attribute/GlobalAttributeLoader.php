<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-30
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use InvalidArgumentException;
use JTL\SCX\Lib\Channel\Helper\FileHandler;

class GlobalAttributeLoader
{
    /**
     * @var FileHandler
     */
    private $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param string $filename
     * @return AttributeList
     */
    public function load(string $filename): AttributeList
    {
        if (!$this->fileHandler->isFile($filename)) {
            throw new InvalidArgumentException("{$filename} is not a valid file");
        }

        $attributJson = $this->fileHandler->readContent($filename);
        $attributeDataList = json_decode($attributJson, true);

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
            $valueList = $this->createValueList(
                $attributeData['values'] ?? null
            );

            $attribute = new Attribute(
                $attributeData['attributeId'],
                $attributeData['displayName'],
                $attributeData['description'] ?? null,
                $attributeData['required'] ?? false,
                $attributeData['enumValues'] ?? null,
                $valueList,
                $attributeData['type'] ? new AttributeType($attributeData['type']) : AttributeType::SMALLTEXT(),
                $attributeData['isMultipleAllowed'] ?? false,
                $attributeData['attributeValueValidation'] ?? null,
                $conditionalMandatory,
                $conditionalOptional,
                $attributeData['section'] ?? null,
                $attributeData['sectionPosition'] ?? null,
                $attributeData['subSection'] ?? null,
                $attributeData['subSectionPosition'] ?? null,
                $attributeData['isVariationDimension'] ?? null
            );
            $attributeList[] = $attribute;
        }

        return $attributeList;
    }

    private function validateDataList($priceDataList): bool
    {
        if (!is_array($priceDataList) || empty($priceDataList)) {
            return false;
        }
        foreach ($priceDataList as $priceData) {
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

    private function createValueList(?array $valueList): ?AllowedValueCollection
    {
        if ($valueList === null) {
            return null;
        }

        $valueCollection = new AllowedValueCollection();

        foreach ($valueList as $value) {
            if (!isset($value['value']) || empty($value['value'])) {
                throw new InvalidArgumentException("Attribute values field 'value' is required");
            }

            $valueCollection->add(
                new AttributeAllowedValue($value['value'], $value['display'] ?? null)
            );
        }

        return $valueCollection;
    }
}
