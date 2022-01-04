<?php
/**
 * OrderItemTypeItemTest
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
 * OrderItemTypeItemTest Class Doc Comment
 *
 * @category    Class
 * @description OrderItemTypeItem
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\OrderItemTypeItem
 */
class OrderItemTypeItemTest extends AbstractApiModelTest
{

    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property OrderItemId' => [
                'orderItemId',
                'string',
                'getOrderItemId',
                'setOrderItemId',
                false
            ],
            'assert property Type' => [
                'type',
                'string',
                'getType',
                'setType',
                false
            ],
            'assert property ItemStatus' => [
                'itemStatus',
                '\JTL\SCX\Lib\Channel\Client\Model\OrderItemStatus',
                'getItemStatus',
                'setItemStatus',
                true
            ],
            'assert property ItemPaymentStatus' => [
                'itemPaymentStatus',
                '\JTL\SCX\Lib\Channel\Client\Model\OrderItemPaymentStatus',
                'getItemPaymentStatus',
                'setItemPaymentStatus',
                true
            ],
            'assert property GrossPrice' => [
                'grossPrice',
                'string',
                'getGrossPrice',
                'setGrossPrice',
                false
            ],
            'assert property Total' => [
                'total',
                'string',
                'getTotal',
                'setTotal',
                false
            ],
            'assert property TaxPercent' => [
                'taxPercent',
                'string',
                'getTaxPercent',
                'setTaxPercent',
                true
            ],
            'assert property GrossFee' => [
                'grossFee',
                'string',
                'getGrossFee',
                'setGrossFee',
                true
            ],
            'assert property OfferId' => [
                'offerId',
                'int',
                'getOfferId',
                'setOfferId',
                true
            ],
            'assert property ChannelOfferId' => [
                'channelOfferId',
                'string',
                'getChannelOfferId',
                'setChannelOfferId',
                true
            ],
            'assert property Sku' => [
                'sku',
                'string',
                'getSku',
                'setSku',
                true
            ],
            'assert property Quantity' => [
                'quantity',
                'string',
                'getQuantity',
                'setQuantity',
                false
            ],
            'assert property Title' => [
                'title',
                'string',
                'getTitle',
                'setTitle',
                true
            ],
            'assert property EstimatedShippingDate' => [
                'estimatedShippingDate',
                '\DateTime',
                'getEstimatedShippingDate',
                'setEstimatedShippingDate',
                true
            ],
            'assert property EstimatedDeliveryDate' => [
                'estimatedDeliveryDate',
                '\DateTime',
                'getEstimatedDeliveryDate',
                'setEstimatedDeliveryDate',
                true
            ],
            'assert property RemainingQuantity' => [
                'remainingQuantity',
                'string',
                'getRemainingQuantity',
                'setRemainingQuantity',
                true
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(string $property, string $type, string $expectedGetter, string $expectedSetter, bool $isNullable): void
    {
        $sample = $this->buildSampleForDataType($type);
        $sut = new OrderItemTypeItem([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);

        if ($isNullable) {
            $sut = new OrderItemTypeItem([$property => null]);
            $this->assertNull($sut->$expectedGetter());

            $sut->$expectedSetter(null);
            $this->assertNull($sut->$expectedGetter());
        }
    }
}
