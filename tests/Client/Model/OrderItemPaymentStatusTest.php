<?php
/**
 * OrderItemPaymentStatusTest
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
 * OrderItemPaymentStatusTest Class Doc Comment
 *
 * @category    Class
 * @description The current payment status  * **PENDING**: Order Item is not yet paid. * **PAID**: Order Item is complete paid.
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\OrderItemPaymentStatus
 */
class OrderItemPaymentStatusTest extends AbstractApiModelTest
{
    /**
     * Test Enum Value "PENDING"
     * @test
     */
    public function is_a_const_PENDING(): void
    {
        self::assertEquals('PENDING', OrderItemPaymentStatus::PENDING);
        $sut = new OrderItemPaymentStatus('PENDING');
        self::assertEquals('PENDING', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "PENDING"
     * @test
     */
    public function it_can_be_constructed_forPENDING(): void
    {
        $sut = OrderItemPaymentStatus::PENDING();
        self::assertInstanceOf(OrderItemPaymentStatus::class, $sut);
    }
    /**
     * Test Enum Value "PAID"
     * @test
     */
    public function is_a_const_PAID(): void
    {
        self::assertEquals('PAID', OrderItemPaymentStatus::PAID);
        $sut = new OrderItemPaymentStatus('PAID');
        self::assertEquals('PAID', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "PAID"
     * @test
     */
    public function it_can_be_constructed_forPAID(): void
    {
        $sut = OrderItemPaymentStatus::PAID();
        self::assertInstanceOf(OrderItemPaymentStatus::class, $sut);
    }

    /**
     * Test allowed values from Enum
     * @test
     */
    public function it_has_correct_set_of_allowed_values(): void
    {
        $allowed = [
            OrderItemPaymentStatus::PENDING,
            OrderItemPaymentStatus::PAID,
        ];
        self::assertEquals($allowed, OrderItemPaymentStatus::getAllowableEnumValues());
    }

}
