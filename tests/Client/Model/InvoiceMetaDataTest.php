<?php
/**
 * InvoiceMetaDataTest
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * JTL-Channel API
 *
 * JTL-Channel API is a REST-based API that helps a Channel Integrator to connect Markeptlace with the JTL-Wawi  ERP System.  # Key Features  With the JTL-Channel API, you can:    * Describe connected Markeplace Data Structure by providing Category and Attribute Data   * Manage Product and Offer Listings   * Manage Orders    * Handle the Post Order Process  # Terminology  * ***Channel***: A Channel is a connection to a Marketplace or any external System which can be connected  to JTL-Channel API * ***Seller***: A Seller is a person - identified by a Id (sellerId) - who want to offer and sells his good  on the connected Channel. * ***Events***: A Event is a action initiated from a Seller. A Channel need to react on those Events in order  to create or update a Offer or to process some Post Orders actions. * ***Seller API***: This is the counter part for the Channel API. The ERP System JTL-Wawi is connected with the  Seller API.  # Seller Management  A Channel need do manage there Seller Accounts by itself. JTL will never be aware of any credentials  which are required by individual Seller to connect to certain Marketplace or externen System  (for example: API Credentials)  Each Channel must maintain a SignUpUrl and UpdateUrl. Those URLs pointing to a Login or Signup Page, hosted by the Channel itself. A Seller will create a SignUp or Update Session inside JTL-Wawi, which redirect the Seller together with a short lived and unique SessionId to the Channels hostes SignUp/Update URLs.  ## Example:  Seller Create a SignUp URL for Channel `MYCHANNEL using the Seller API ``` curl --location --request POST 'https://scx-sbx.api.jtl-software.com/v1/seller/channel/MYCHANNEL' \\ --header 'Authorization: Bearer eyJ01234567890dummy' ```  Response  ``` {   \"signUpUrl\": \"https://www.mychannel.com/?session=Ylc53NQr4bE2zaJOnMQ3JziabJMHVJCysodFiHZEfCYhVKh41cdQTJSD7BNfliys&expiresAt=1646759360\",   \"expiresAt\": 1646759360 } ```  Seller is redirect to the `signUpUrl`.   On the SignUp Page the Channel must ask for Seller identification. If a Seller is considered as valid and authenticated.  The Channel itself must create a unique SellerId and send them together with the sessionId, from the SignUp URL to  the Channel API.   ***Note***: All Events from the Channel API will have a SellerId. This sellerId is immutable and can not be changed  afterwards.  ``` curl --location --request POST 'https://scx-sbx.api.jtl-software.com/v1/channel/seller' \\ --header 'Authorization: Bearer eyJ01234567890dummy' \\ --header 'Content-Type: application/json' \\ --data-raw '{   \"session\": \"Ylc53NQr4bE2zaJOnMQ3JziabJMHVJCysodFiHZEfCYhVKh41cdQTJSD7BNfliys\",   \"sellerId\": \"1\" }' ```
 *
 * The version of the OpenAPI document: 1.0.0
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.4.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the model.
 */

namespace JTL\SCX\Lib\Channel\Client\Model;

use JTL\SCX\Lib\Channel\Client\AbstractApiModelTest;
use JTL\SCX\Lib\Channel\Client\ObjectSerializer;

/**
 * InvoiceMetaDataTest Class Doc Comment
 *
 * @category    Class
 * @description InvoiceMetaData
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\InvoiceMetaData
 */
class InvoiceMetaDataTest extends AbstractApiModelTest
{
    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property Type' => [
                'type',
                '\JTL\SCX\Lib\Channel\Client\Model\InvoiceDocumentType',
                'getType',
                'setType',
                false
            ],
            'assert property SellerId' => [
                'sellerId',
                'string',
                'getSellerId',
                'setSellerId',
                false
            ],
            'assert property OrderId' => [
                'orderId',
                'string',
                'getOrderId',
                'setOrderId',
                false
            ],
            'assert property InvoiceNumber' => [
                'invoiceNumber',
                'string',
                'getInvoiceNumber',
                'setInvoiceNumber',
                false
            ],
            'assert property OriginalInvoiceNumber' => [
                'originalInvoiceNumber',
                'string',
                'getOriginalInvoiceNumber',
                'setOriginalInvoiceNumber',
                true
            ],
            'assert property TransactionDate' => [
                'transactionDate',
                '\DateTime',
                'getTransactionDate',
                'setTransactionDate',
                true
            ],
            'assert property TransactionDetails' => [
                'transactionDetails',
                'string',
                'getTransactionDetails',
                'setTransactionDetails',
                true
            ],
            'assert property TaxCalculationDate' => [
                'taxCalculationDate',
                '\DateTime',
                'getTaxCalculationDate',
                'setTaxCalculationDate',
                true
            ],
            'assert property ShipmentDate' => [
                'shipmentDate',
                '\DateTime',
                'getShipmentDate',
                'setShipmentDate',
                true
            ],
            'assert property TaxAddressRole' => [
                'taxAddressRole',
                'string',
                'getTaxAddressRole',
                'setTaxAddressRole',
                true
            ],
            'assert property ExportOutsideEu' => [
                'exportOutsideEu',
                'bool',
                'getExportOutsideEu',
                'setExportOutsideEu',
                true
            ],
            'assert property Currency' => [
                'currency',
                'string',
                'getCurrency',
                'setCurrency',
                true
            ],
            'assert property BillingAddress' => [
                'billingAddress',
                '\JTL\SCX\Lib\Channel\Client\Model\Address',
                'getBillingAddress',
                'setBillingAddress',
                true
            ],
            'assert property SellerVatNumber' => [
                'sellerVatNumber',
                'string',
                'getSellerVatNumber',
                'setSellerVatNumber',
                true
            ],
            'assert property BuyerVatNumber' => [
                'buyerVatNumber',
                'string',
                'getBuyerVatNumber',
                'setBuyerVatNumber',
                true
            ],
            'assert property OrderList' => [
                'orderList',
                '\JTL\SCX\Lib\Channel\Client\Model\OrderInvoice[]',
                'getOrderList',
                'setOrderList',
                true
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(
        string $property,
        string $type,
        string $expectedGetter,
        string $expectedSetter,
        bool $isNullable
    ): void {
        $sample = $this->buildSampleForDataType($type);
        $sut = new InvoiceMetaData([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);

        if ($isNullable) {
            $sut = new InvoiceMetaData([$property => null]);
            $this->assertNull($sut->$expectedGetter());

            $sut->$expectedSetter(null);
            $this->assertNull($sut->$expectedGetter());
        }
    }

    /**
     * @test
     */
    public function it_has_allowed_values_for_taxAddressRole(): void
    {
        $sut = new InvoiceMetaData();
        self::assertEquals(['shipFrom', 'shipTo'], $sut->getTaxAddressRoleAllowableValues());
    }


}
