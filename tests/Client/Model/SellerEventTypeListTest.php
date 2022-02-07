<?php
/**
 * SellerEventTypeListTest
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
 * SellerEventTypeListTest Class Doc Comment
 *
 * @category    Class
 * @description SellerEventTypeList
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\SellerEventTypeList
 */
class SellerEventTypeListTest extends AbstractApiModelTest
{
    /**
     * Test Enum Value "SYSTEMTEST"
     * @test
     */
    public function is_a_const_SYSTEMTEST(): void
    {
        self::assertEquals('System:Test', SellerEventTypeList::SYSTEMTEST);
        $sut = new SellerEventTypeList('System:Test');
        self::assertEquals('System:Test', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SYSTEMTEST"
     * @test
     */
    public function it_can_be_constructed_forSYSTEMTEST(): void
    {
        $sut = SellerEventTypeList::SYSTEMTEST();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SYSTEMNOTIFICATION"
     * @test
     */
    public function is_a_const_SYSTEMNOTIFICATION(): void
    {
        self::assertEquals('System:Notification', SellerEventTypeList::SYSTEMNOTIFICATION);
        $sut = new SellerEventTypeList('System:Notification');
        self::assertEquals('System:Notification', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SYSTEMNOTIFICATION"
     * @test
     */
    public function it_can_be_constructed_forSYSTEMNOTIFICATION(): void
    {
        $sut = SellerEventTypeList::SYSTEMNOTIFICATION();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_ACCEPTED"
     * @test
     */
    public function is_a_const_SELLERORDER_ACCEPTED(): void
    {
        self::assertEquals('Seller:Order.Accepted', SellerEventTypeList::SELLERORDER_ACCEPTED);
        $sut = new SellerEventTypeList('Seller:Order.Accepted');
        self::assertEquals('Seller:Order.Accepted', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_ACCEPTED"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_ACCEPTED(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_ACCEPTED();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_SHIPPING"
     * @test
     */
    public function is_a_const_SELLERORDER_SHIPPING(): void
    {
        self::assertEquals('Seller:Order.Shipping', SellerEventTypeList::SELLERORDER_SHIPPING);
        $sut = new SellerEventTypeList('Seller:Order.Shipping');
        self::assertEquals('Seller:Order.Shipping', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_SHIPPING"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_SHIPPING(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_SHIPPING();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_PAYMENT"
     * @test
     */
    public function is_a_const_SELLERORDER_PAYMENT(): void
    {
        self::assertEquals('Seller:Order.Payment', SellerEventTypeList::SELLERORDER_PAYMENT);
        $sut = new SellerEventTypeList('Seller:Order.Payment');
        self::assertEquals('Seller:Order.Payment', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_PAYMENT"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_PAYMENT(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_PAYMENT();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_CANCELLATION_REQUEST"
     * @test
     */
    public function is_a_const_SELLERORDER_CANCELLATION_REQUEST(): void
    {
        self::assertEquals('Seller:Order.Cancellation.Request', SellerEventTypeList::SELLERORDER_CANCELLATION_REQUEST);
        $sut = new SellerEventTypeList('Seller:Order.Cancellation.Request');
        self::assertEquals('Seller:Order.Cancellation.Request', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_CANCELLATION_REQUEST"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_CANCELLATION_REQUEST(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_CANCELLATION_REQUEST();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_CANCELLATION_ACCEPTED"
     * @test
     */
    public function is_a_const_SELLERORDER_CANCELLATION_ACCEPTED(): void
    {
        self::assertEquals('Seller:Order.Cancellation.Accepted', SellerEventTypeList::SELLERORDER_CANCELLATION_ACCEPTED);
        $sut = new SellerEventTypeList('Seller:Order.Cancellation.Accepted');
        self::assertEquals('Seller:Order.Cancellation.Accepted', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_CANCELLATION_ACCEPTED"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_CANCELLATION_ACCEPTED(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_CANCELLATION_ACCEPTED();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_CANCELLATION_DENIED"
     * @test
     */
    public function is_a_const_SELLERORDER_CANCELLATION_DENIED(): void
    {
        self::assertEquals('Seller:Order.Cancellation.Denied', SellerEventTypeList::SELLERORDER_CANCELLATION_DENIED);
        $sut = new SellerEventTypeList('Seller:Order.Cancellation.Denied');
        self::assertEquals('Seller:Order.Cancellation.Denied', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_CANCELLATION_DENIED"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_CANCELLATION_DENIED(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_CANCELLATION_DENIED();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_REFUND"
     * @test
     */
    public function is_a_const_SELLERORDER_REFUND(): void
    {
        self::assertEquals('Seller:Order.Refund', SellerEventTypeList::SELLERORDER_REFUND);
        $sut = new SellerEventTypeList('Seller:Order.Refund');
        self::assertEquals('Seller:Order.Refund', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_REFUND"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_REFUND(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_REFUND();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_INVOICE"
     * @test
     */
    public function is_a_const_SELLERORDER_INVOICE(): void
    {
        self::assertEquals('Seller:Order.Invoice', SellerEventTypeList::SELLERORDER_INVOICE);
        $sut = new SellerEventTypeList('Seller:Order.Invoice');
        self::assertEquals('Seller:Order.Invoice', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_INVOICE"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_INVOICE(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_INVOICE();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERORDER_RETURN_RECEIVED"
     * @test
     */
    public function is_a_const_SELLERORDER_RETURN_RECEIVED(): void
    {
        self::assertEquals('Seller:Order.ReturnReceived', SellerEventTypeList::SELLERORDER_RETURN_RECEIVED);
        $sut = new SellerEventTypeList('Seller:Order.ReturnReceived');
        self::assertEquals('Seller:Order.ReturnReceived', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERORDER_RETURN_RECEIVED"
     * @test
     */
    public function it_can_be_constructed_forSELLERORDER_RETURN_RECEIVED(): void
    {
        $sut = SellerEventTypeList::SELLERORDER_RETURN_RECEIVED();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLEROFFER_NEW"
     * @test
     */
    public function is_a_const_SELLEROFFER_NEW(): void
    {
        self::assertEquals('Seller:Offer.New', SellerEventTypeList::SELLEROFFER_NEW);
        $sut = new SellerEventTypeList('Seller:Offer.New');
        self::assertEquals('Seller:Offer.New', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLEROFFER_NEW"
     * @test
     */
    public function it_can_be_constructed_forSELLEROFFER_NEW(): void
    {
        $sut = SellerEventTypeList::SELLEROFFER_NEW();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLEROFFER_UPDATE"
     * @test
     */
    public function is_a_const_SELLEROFFER_UPDATE(): void
    {
        self::assertEquals('Seller:Offer.Update', SellerEventTypeList::SELLEROFFER_UPDATE);
        $sut = new SellerEventTypeList('Seller:Offer.Update');
        self::assertEquals('Seller:Offer.Update', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLEROFFER_UPDATE"
     * @test
     */
    public function it_can_be_constructed_forSELLEROFFER_UPDATE(): void
    {
        $sut = SellerEventTypeList::SELLEROFFER_UPDATE();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLEROFFER_END"
     * @test
     */
    public function is_a_const_SELLEROFFER_END(): void
    {
        self::assertEquals('Seller:Offer.End', SellerEventTypeList::SELLEROFFER_END);
        $sut = new SellerEventTypeList('Seller:Offer.End');
        self::assertEquals('Seller:Offer.End', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLEROFFER_END"
     * @test
     */
    public function it_can_be_constructed_forSELLEROFFER_END(): void
    {
        $sut = SellerEventTypeList::SELLEROFFER_END();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLEROFFER_STOCK_UPDATE"
     * @test
     */
    public function is_a_const_SELLEROFFER_STOCK_UPDATE(): void
    {
        self::assertEquals('Seller:Offer.StockUpdate', SellerEventTypeList::SELLEROFFER_STOCK_UPDATE);
        $sut = new SellerEventTypeList('Seller:Offer.StockUpdate');
        self::assertEquals('Seller:Offer.StockUpdate', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLEROFFER_STOCK_UPDATE"
     * @test
     */
    public function it_can_be_constructed_forSELLEROFFER_STOCK_UPDATE(): void
    {
        $sut = SellerEventTypeList::SELLEROFFER_STOCK_UPDATE();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLEROFFER_PRICE_UPDATE"
     * @test
     */
    public function is_a_const_SELLEROFFER_PRICE_UPDATE(): void
    {
        self::assertEquals('Seller:Offer.PriceUpdate', SellerEventTypeList::SELLEROFFER_PRICE_UPDATE);
        $sut = new SellerEventTypeList('Seller:Offer.PriceUpdate');
        self::assertEquals('Seller:Offer.PriceUpdate', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLEROFFER_PRICE_UPDATE"
     * @test
     */
    public function it_can_be_constructed_forSELLEROFFER_PRICE_UPDATE(): void
    {
        $sut = SellerEventTypeList::SELLEROFFER_PRICE_UPDATE();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERREPORT_REQUEST"
     * @test
     */
    public function is_a_const_SELLERREPORT_REQUEST(): void
    {
        self::assertEquals('Seller:Report.Request', SellerEventTypeList::SELLERREPORT_REQUEST);
        $sut = new SellerEventTypeList('Seller:Report.Request');
        self::assertEquals('Seller:Report.Request', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERREPORT_REQUEST"
     * @test
     */
    public function it_can_be_constructed_forSELLERREPORT_REQUEST(): void
    {
        $sut = SellerEventTypeList::SELLERREPORT_REQUEST();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERCHANNEL_UNLINKED"
     * @test
     */
    public function is_a_const_SELLERCHANNEL_UNLINKED(): void
    {
        self::assertEquals('Seller:Channel.Unlinked', SellerEventTypeList::SELLERCHANNEL_UNLINKED);
        $sut = new SellerEventTypeList('Seller:Channel.Unlinked');
        self::assertEquals('Seller:Channel.Unlinked', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERCHANNEL_UNLINKED"
     * @test
     */
    public function it_can_be_constructed_forSELLERCHANNEL_UNLINKED(): void
    {
        $sut = SellerEventTypeList::SELLERCHANNEL_UNLINKED();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST"
     * @test
     */
    public function is_a_const_SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST(): void
    {
        self::assertEquals('Seller:Meta.SellerAttributesUpdateRequest', SellerEventTypeList::SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST);
        $sut = new SellerEventTypeList('Seller:Meta.SellerAttributesUpdateRequest');
        self::assertEquals('Seller:Meta.SellerAttributesUpdateRequest', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST"
     * @test
     */
    public function it_can_be_constructed_forSELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST(): void
    {
        $sut = SellerEventTypeList::SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }
    /**
     * Test Enum Value "SELLERTICKET_REPLY"
     * @test
     */
    public function is_a_const_SELLERTICKET_REPLY(): void
    {
        self::assertEquals('Seller:Ticket.Reply', SellerEventTypeList::SELLERTICKET_REPLY);
        $sut = new SellerEventTypeList('Seller:Ticket.Reply');
        self::assertEquals('Seller:Ticket.Reply', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "SELLERTICKET_REPLY"
     * @test
     */
    public function it_can_be_constructed_forSELLERTICKET_REPLY(): void
    {
        $sut = SellerEventTypeList::SELLERTICKET_REPLY();
        self::assertInstanceOf(SellerEventTypeList::class, $sut);
    }

    /**
     * Test allowed values from Enum
     * @test
     */
    public function it_has_correct_set_of_allowed_values(): void
    {
        $allowed = [
            SellerEventTypeList::SYSTEMTEST,
            SellerEventTypeList::SYSTEMNOTIFICATION,
            SellerEventTypeList::SELLERORDER_ACCEPTED,
            SellerEventTypeList::SELLERORDER_SHIPPING,
            SellerEventTypeList::SELLERORDER_PAYMENT,
            SellerEventTypeList::SELLERORDER_CANCELLATION_REQUEST,
            SellerEventTypeList::SELLERORDER_CANCELLATION_ACCEPTED,
            SellerEventTypeList::SELLERORDER_CANCELLATION_DENIED,
            SellerEventTypeList::SELLERORDER_REFUND,
            SellerEventTypeList::SELLERORDER_INVOICE,
            SellerEventTypeList::SELLERORDER_RETURN_RECEIVED,
            SellerEventTypeList::SELLEROFFER_NEW,
            SellerEventTypeList::SELLEROFFER_UPDATE,
            SellerEventTypeList::SELLEROFFER_END,
            SellerEventTypeList::SELLEROFFER_STOCK_UPDATE,
            SellerEventTypeList::SELLEROFFER_PRICE_UPDATE,
            SellerEventTypeList::SELLERREPORT_REQUEST,
            SellerEventTypeList::SELLERCHANNEL_UNLINKED,
            SellerEventTypeList::SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST,
            SellerEventTypeList::SELLERTICKET_REPLY,
        ];
        self::assertEquals($allowed, SellerEventTypeList::getAllowableEnumValues());
    }

}
