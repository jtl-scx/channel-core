<?php
/**
 * InvoiceDocumentTypeTest
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * SCX Channel API
 *
 * SCX Channel API
 *
 * The version of the OpenAPI document: 1.0.0
 * 
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.1.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the model.
 */

namespace JTL\SCX\Lib\Channel\Client\Model;

use JTL\SCX\Lib\Channel\Client\AbstractApiModelTest;

/**
 * InvoiceDocumentTypeTest Class Doc Comment
 *
 * @category    Class
 * @description InvoiceDocumentType
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\InvoiceDocumentType
 */
class InvoiceDocumentTypeTest extends AbstractApiModelTest
{
    /**
     * Test Enum Value "INVOICE"
     * @test
     */
    public function is_a_const_INVOICE(): void
    {
        self::assertEquals('INVOICE', InvoiceDocumentType::INVOICE);
        $sut = new InvoiceDocumentType('INVOICE');
        self::assertEquals('INVOICE', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "INVOICE"
     * @test
     */
    public function it_can_be_constructed_forINVOICE(): void
    {
        $sut = InvoiceDocumentType::INVOICE();
        self::assertInstanceOf(InvoiceDocumentType::class, $sut);
    }
    /**
     * Test Enum Value "CREDITNOTE"
     * @test
     */
    public function is_a_const_CREDITNOTE(): void
    {
        self::assertEquals('CREDITNOTE', InvoiceDocumentType::CREDITNOTE);
        $sut = new InvoiceDocumentType('CREDITNOTE');
        self::assertEquals('CREDITNOTE', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "CREDITNOTE"
     * @test
     */
    public function it_can_be_constructed_forCREDITNOTE(): void
    {
        $sut = InvoiceDocumentType::CREDITNOTE();
        self::assertInstanceOf(InvoiceDocumentType::class, $sut);
    }

    /**
     * Test allowed values from Enum
     * @test
     */
    public function it_has_correct_set_of_allowed_values(): void
    {
        $allowed = [
            InvoiceDocumentType::INVOICE,
            InvoiceDocumentType::CREDITNOTE,
        ];
        self::assertEquals($allowed, InvoiceDocumentType::getAllowableEnumValues());
    }

}
