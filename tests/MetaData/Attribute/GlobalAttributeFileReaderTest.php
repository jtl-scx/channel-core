<?php

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use InvalidArgumentException;
use JsonException;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeFileReader
 */
class GlobalAttributeFileReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_load_attributes_from_file(): void
    {
        $random = static fn() => random_int(0, 1) === 0 ? 'false' : 'true';
        $isRequired = $isMultipleAllowed = $isVariationDimension = $isRecommended = $isRepeatableSubSection = $random();
        $sut = $this->setupGlobalAttributeFileReader(
            <<<JSON
[
    {
        "attributeId": "testId"
        , "displayName": "testDisplayName"
        , "description": "any-description"
        , "required": $isRequired
        , "isMultipleAllowed": $isMultipleAllowed
        , "attributeValueValidation": "abc"
        , "section": "a-section"
        , "sectionPosition": 123
        , "subSection": "a-subsection"
        , "subSectionPosition": 456
        , "isVariationDimension": $isVariationDimension
        , "recommended": $isRecommended
        , "values": [{"value": "123", "display": "foo"}]
        , "isRepeatableSubSection": $isRepeatableSubSection
    },
    {
        "attributeId": "testId2",
        "displayName": "testDisplayName2"
    }
]
JSON
        );

        $result = $sut->read('foo.json');

        self::assertArrayHasKey(0, $result);
        $attribute = $result[0];
        self::assertEquals('testId', $attribute->getAttributeId());
        self::assertEquals('testDisplayName', $attribute->getDisplayName());
        self::assertEquals('any-description', $attribute->getDescription());
        self::assertEquals($isRequired === 'true', $attribute->isRequired());
        self::assertEquals($isMultipleAllowed === 'true', $attribute->isMultipleAllowed());
        self::assertEquals("abc", $attribute->getAttributeValueValidation());
        self::assertEquals("a-section", $attribute->getSection());
        self::assertEquals(123, $attribute->getSectionPosition());
        self::assertEquals("a-subsection", $attribute->getSubSection());
        self::assertEquals(456, $attribute->getSubSectionPosition());
        self::assertEquals($isVariationDimension === 'true', $attribute->isVariationDimension());
        self::assertEquals($isRecommended === 'true', $attribute->isRecommended());
        self::assertNull($attribute->getValues());

        self::assertArrayHasKey(1, $result);
        $attribute = $result[1];
        self::assertEquals('testId2', $attribute->getAttributeId());
        self::assertEquals('testDisplayName2', $attribute->getDisplayName());
        self::assertNull($attribute->getDescription());
        self::assertFalse($attribute->isRequired());
        self::assertFalse($attribute->isMultipleAllowed());
        self::assertNull($attribute->getAttributeValueValidation());
        self::assertNull($attribute->getSection());
        self::assertNull($attribute->getSectionPosition());
        self::assertNull($attribute->getSubSection());
        self::assertNull($attribute->getSubSectionPosition());
        self::assertNull($attribute->isVariationDimension());
        self::assertNull($attribute->isRecommended());
    }

    /**
     * @test
     */
    public function it_has_enumValues_when_type_is_ENUM(): void
    {
        $sut = $this->setupGlobalAttributeFileReader(
            /** @lang JSON */
            <<<JSON
[
    {
        "-comment": "ENUM type - with values property",
        "attributeId": "testId",
        "displayName": "testDisplayName",
        "type": "enum",
        "values": [
            {"value": "1"},
            {"value": "3", "display": "dinges"}
        ]
    },
    {
        "-comment": "Not a  ENUM type - should not have a AttributeEnumValueList",
        "attributeId": "testId2",
        "displayName": "testDisplayName2",
        "type": "boolean"
    },
    {
        "-comment": "Just for backwards compatibility we also support enumValues",
        "attributeId": "testId3",
        "displayName": "testDisplayName3",
        "type": "enum",
        "enumValues": ["1", "2"]
    },
    {
        "-comment": "enum values must not have a AttributeEnumValueList",
        "attributeId": "testId3",
        "displayName": "testDisplayName3",
        "type": "enum"
    }
]
JSON
        );

        $result = $sut->read('foo.json');

        self::assertArrayHasKey(0, $result);
        $attribute = $result[0];
        $values = $attribute->getValues();
        self::assertInstanceOf(AttributeEnumValueList::class, $values);
        self::assertCount(2, $values);

        self::assertArrayHasKey(1, $result);
        $attribute = $result[1];
        self::assertNull($attribute->getValues());

        self::assertArrayHasKey(2, $result);
        $attribute = $result[2];
        $values = $attribute->getValues();
        self::assertInstanceOf(AttributeEnumValueList::class, $values);
        self::assertCount(2, $values);

        self::assertArrayHasKey(3, $result);
        $attribute = $result[3];
        $values = $attribute->getValues();
        self::assertInstanceOf(AttributeEnumValueList::class, $values);
        self::assertCount(0, $values);
    }


    /**
     * @test
     */
    public function it_use_smalltext_as_default_type(): void
    {
        $sut = $this->setupGlobalAttributeFileReader(
            <<<JSON
[
    {
        "attributeId": "testId",
        "displayName": "testDisplayName"
    },
    {
        "attributeId": "testId2",
        "displayName": "testDisplayName2",
        "type": "boolean"
    }
]
JSON
        );

        $result = $sut->read('foo.json');

        self::assertArrayHasKey(0, $result);
        $attribute = $result[0];
        self::assertEquals(AttributeType::SMALLTEXT(), $attribute->getType());

        self::assertArrayHasKey(1, $result);
        $attribute = $result[1];
        self::assertEquals(AttributeType::BOOLEAN(), $attribute->getType());
    }

    /**
     * @test
     */
    public function it_fail_when_attributeId_is_missing(): void
    {
        $sut = $this->setupGlobalAttributeFileReader(
            <<<JSON
[
    {
        "this_is_missing-->attributeId": "testId",
        "displayName": "testDisplayName"
    },
    {
        "attributeId": "testId2",
        "displayName": "testDisplayName2"
    }
]
JSON
        );

        self::expectException(InvalidArgumentException::class);
        $sut->read('foo.json');
    }

    /**
     * @test
     */
    public function it_fail_when_displayName_is_missing(): void
    {
        $sut = $this->setupGlobalAttributeFileReader(
            <<<JSON
[
    {
        "attributeId": "testId",
        "displayName": "testDisplayName"
    },
    {
        "attributeId": "testId2",
        "this_is_missing--->displayName": "testDisplayName2"
    }
]
JSON
        );

        self::expectException(InvalidArgumentException::class);
        $sut->read('foo.json');
    }

    /**
     * @test
     */
    public function it_fail_when_json_is_invalid(): void
    {
        $sut = $this->setupGlobalAttributeFileReader("INVALID");

        self::expectException(JsonException::class);
        $sut->read('foo.json');
    }


    private function setupGlobalAttributeFileReader(string $json): GlobalAttributeFileReader
    {
        $fileHandler = $this->createStub(FileHandler::class);
        $sut = new GlobalAttributeFileReader($fileHandler);

        $fileHandler->method('isFile')->willReturn(true);
        $fileHandler->method('readContent')->willReturn($json);

        return $sut;
    }
}
