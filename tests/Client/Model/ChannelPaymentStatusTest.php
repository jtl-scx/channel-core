<?php
/**
 * ChannelPaymentStatusTest
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
 * ChannelPaymentStatusTest Class Doc Comment
 *
 * @category    Class
 * @description The current payment status  * **PENDING**: Order is not yet paid. * **PAID**: Order is complete paid. * **PARTIALLY_PAID**: Order is partially paid.
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\ChannelPaymentStatus
 */
class ChannelPaymentStatusTest extends AbstractApiModelTest
{
    /**
     * Test Enum Value "PENDING"
     * @test
     */
    public function is_a_const_PENDING(): void
    {
        self::assertEquals('PENDING', ChannelPaymentStatus::PENDING);
        $sut = new ChannelPaymentStatus('PENDING');
        self::assertEquals('PENDING', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "PENDING"
     * @test
     */
    public function it_can_be_constructed_forPENDING(): void
    {
        $sut = ChannelPaymentStatus::PENDING();
        self::assertInstanceOf(ChannelPaymentStatus::class, $sut);
    }
    /**
     * Test Enum Value "PAID"
     * @test
     */
    public function is_a_const_PAID(): void
    {
        self::assertEquals('PAID', ChannelPaymentStatus::PAID);
        $sut = new ChannelPaymentStatus('PAID');
        self::assertEquals('PAID', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "PAID"
     * @test
     */
    public function it_can_be_constructed_forPAID(): void
    {
        $sut = ChannelPaymentStatus::PAID();
        self::assertInstanceOf(ChannelPaymentStatus::class, $sut);
    }
    /**
     * Test Enum Value "PARTIALLY_PAID"
     * @test
     */
    public function is_a_const_PARTIALLY_PAID(): void
    {
        self::assertEquals('PARTIALLY_PAID', ChannelPaymentStatus::PARTIALLY_PAID);
        $sut = new ChannelPaymentStatus('PARTIALLY_PAID');
        self::assertEquals('PARTIALLY_PAID', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "PARTIALLY_PAID"
     * @test
     */
    public function it_can_be_constructed_forPARTIALLY_PAID(): void
    {
        $sut = ChannelPaymentStatus::PARTIALLY_PAID();
        self::assertInstanceOf(ChannelPaymentStatus::class, $sut);
    }

    /**
     * Test allowed values from Enum
     * @test
     */
    public function it_has_correct_set_of_allowed_values(): void
    {
        $allowed = [
            ChannelPaymentStatus::PENDING,
            ChannelPaymentStatus::PAID,
            ChannelPaymentStatus::PARTIALLY_PAID,
        ];
        self::assertEquals($allowed, ChannelPaymentStatus::getAllowableEnumValues());
    }

}
