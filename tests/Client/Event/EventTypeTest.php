<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/31/20
 */

namespace JTL\SCX\Lib\Channel\Client\Event;

use JTL\SCX\Lib\Channel\Client\Model\SellerEventChannelUnlinked;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferPriceUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferStockUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderAccept;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationAccepted;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationDenied;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderConfirmed;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderInvoice;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderRefund;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderReturnReceived;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventReportRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Event\EventType
 */
class EventTypeTest extends TestCase
{
    public function mapProvider(): array
    {
        return [
            [SellerEventTest::class, EventType::SellerEventTest()],
            [SystemEventNotification::class, EventType::SystemNotification()],
            [SellerEventOrderConfirmed::class, EventType::SellerOrderConfirmed()],
            [SellerEventOrderShipping::class, EventType::SellerOrderShipping()],
            [SellerEventOrderPayment::class, EventType::SellerOrderPayment()],
            [SellerEventOfferNew::class, EventType::SellerOfferNew()],
            [SellerEventOfferUpdate::class, EventType::SellerOfferUpdate()],
            [SellerEventOfferEnd::class, EventType::SellerOfferEnd()],
            [SellerEventOfferStockUpdate::class, EventType::SellerOfferStockUpdate()],
            [SellerEventOfferPriceUpdate::class, EventType::SellerOfferPriceUpdate()],
            [SellerEventReportRequest::class, EventType::SellerReportRequest()],
            [SellerEventChannelUnlinked::class, EventType::SellerChannelUnlinked()],
            [SellerEventSellerAttributesUpdateRequest::class, EventType::SellerMetaSellerAttributesUpdateRequest()],
            [SellerEventOrderCancellationAccepted::class, EventType::SellerOrderCancellationAccept()],
            [SellerEventOrderCancellationDenied::class, EventType::SellerOrderCancellationDenied()],
            [SellerEventOrderCancellationRequest::class, EventType::SellerOrderCancellationRequest()],
            [SellerEventOrderInvoice::class, EventType::SellerEventOrderInvoice()],
            [SellerEventOrderRefund::class, EventType::SellerEventOrderRefund()],
            [SellerEventOrderReturnReceived::class, EventType::SellerOrderReturnReceived()],
            [\stdClass::class, new EventType('FooBarEvent')],
        ];
    }

    /**
     * @dataProvider mapProvider
     */
    public function testCanMapToCorrectModelClass(string $expectation, EventType $type)
    {
        $this->assertEquals($expectation, $type->getEventModelClass());
    }

    public function testCanBuildWithUnknownEvent()
    {
        $this->assertInstanceOf(EventType::class, new EventType('foobardingens'));
    }

    public function testIsUnknownEventType()
    {
        $this->assertTrue((new EventType('foobardingens'))->isUnknownEventType());
        $this->assertFalse(EventType::SellerEventTest()->isUnknownEventType());
    }
}
