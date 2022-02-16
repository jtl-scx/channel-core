<?php
/**
 * OrderTest
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
 * OrderTest Class Doc Comment
 *
 * @category    Class
 * @description Order
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\Order
 */
class OrderTest extends AbstractApiModelTest
{


    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property SellerId' => [
                'sellerId',
                'string',
                'getSellerId',
                'setSellerId'
            ],
            'assert property OrderStatus' => [
                'orderStatus',
                '\JTL\SCX\Lib\Channel\Client\Model\ChannelOrderStatus',
                'getOrderStatus',
                'setOrderStatus'
            ],
            'assert property OrderAcceptUntil' => [
                'orderAcceptUntil',
                '\DateTime',
                'getOrderAcceptUntil',
                'setOrderAcceptUntil'
            ],
            'assert property PaymentStatus' => [
                'paymentStatus',
                '\JTL\SCX\Lib\Channel\Client\Model\ChannelPaymentStatus',
                'getPaymentStatus',
                'setPaymentStatus'
            ],
            'assert property PaymentMethod' => [
                'paymentMethod',
                'string',
                'getPaymentMethod',
                'setPaymentMethod'
            ],
            'assert property PaymentReference' => [
                'paymentReference',
                'string',
                'getPaymentReference',
                'setPaymentReference'
            ],
            'assert property OrderId' => [
                'orderId',
                'string',
                'getOrderId',
                'setOrderId'
            ],
            'assert property PurchasedAt' => [
                'purchasedAt',
                '\DateTime',
                'getPurchasedAt',
                'setPurchasedAt'
            ],
            'assert property LastChangedAt' => [
                'lastChangedAt',
                '\DateTime',
                'getLastChangedAt',
                'setLastChangedAt'
            ],
            'assert property Currency' => [
                'currency',
                'string',
                'getCurrency',
                'setCurrency'
            ],
            'assert property OrderItem' => [
                'orderItem',
                '\JTL\SCX\Lib\Channel\Client\Model\OrderItem[]',
                'getOrderItem',
                'setOrderItem'
            ],
            'assert property BillingAddress' => [
                'billingAddress',
                '\JTL\SCX\Lib\Channel\Client\Model\Address',
                'getBillingAddress',
                'setBillingAddress'
            ],
            'assert property ShippingAddress' => [
                'shippingAddress',
                '\JTL\SCX\Lib\Channel\Client\Model\Address',
                'getShippingAddress',
                'setShippingAddress'
            ],
            'assert property Note' => [
                'note',
                'string',
                'getNote',
                'setNote'
            ],
            'assert property Buyer' => [
                'buyer',
                '\JTL\SCX\Lib\Channel\Client\Model\OrderBuyer',
                'getBuyer',
                'setBuyer'
            ],
            'assert weee pickup' => [
                'weeePickup',
                'bool',
                'getWeeePickup',
                'setWeeePickup'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(string $property, string $type, string $expectedGetter, string $expectedSetter): void
    {
        $sample = $this->buildSampleForDataType($type);
        $sut = new Order([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);
    }
}
