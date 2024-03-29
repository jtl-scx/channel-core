<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event;

use DateTimeImmutable;
use Exception;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
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
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderInvoice;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderRefund;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderReturnReceived;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventReportRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;
use JTL\SCX\Lib\Channel\Event\Seller\ChannelUnlinkedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferPriceUpdateEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferStockUpdateEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferUpdateEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderAcceptEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationAcceptedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationDeniedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancellationRequestEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderInvoiceEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderPaymentEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderRefundEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderReturnReceived;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\ReportRequestEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;
use PHPUnit\Framework\TestCase;

/**
 * Class EventFactoryTest
 * @covers \JTL\SCX\Lib\Channel\Event\EventFactory
 */
class EventFactoryTest extends TestCase
{
    public function eventTestCasesProvider(): array
    {
        return [
            [SystemNotificationEvent::class, SystemEventNotification::class, EventType::SystemNotification()],
            [SystemTestEvent::class, SellerEventTest::class, EventType::SellerEventTest()],
            [OrderAcceptEvent::class, SellerEventOrderAccept::class, EventType::SellerOrderAccept()],
            [OrderShippingEvent::class, SellerEventOrderShipping::class, EventType::SellerOrderShipping()],
            [OrderPaymentEvent::class, SellerEventOrderPayment::class, EventType::SellerOrderPayment()],
            [
                OrderCancellationRequestEvent::class,
                SellerEventOrderCancellationRequest::class,
                EventType::SellerOrderCancellationRequest(),
            ],
            [OfferEndEvent::class, SellerEventOfferEnd::class, EventType::SellerOfferEnd()],
            [OfferNewEvent::class, SellerEventOfferNew::class, EventType::SellerOfferNew()],
            [OfferUpdateEvent::class, SellerEventOfferUpdate::class, EventType::SellerOfferUpdate()],
            [OfferStockUpdateEvent::class, SellerEventOfferStockUpdate::class, EventType::SellerOfferStockUpdate()],
            [OfferPriceUpdateEvent::class, SellerEventOfferPriceUpdate::class, EventType::SellerOfferPriceUpdate()],
            [ReportRequestEvent::class, SellerEventReportRequest::class, EventType::SellerReportRequest()],
            [ChannelUnlinkedEvent::class, SellerEventChannelUnlinked::class, EventType::SellerChannelUnlinked()],
            [
                AttributesUpdateRequestEvent::class,
                SellerEventSellerAttributesUpdateRequest::class,
                EventType::SellerMetaSellerAttributesUpdateRequest(),
            ],
            [
                OrderCancellationAcceptedEvent::class,
                SellerEventOrderCancellationAccepted::class,
                EventType::SellerOrderCancellationAccept(),
            ],
            [
                OrderCancellationDeniedEvent::class,
                SellerEventOrderCancellationDenied::class,
                EventType::SellerOrderCancellationDenied(),
            ],
            [OrderInvoiceEvent::class, SellerEventOrderInvoice::class, EventType::SellerEventOrderInvoice()],
            [OrderRefundEvent::class, SellerEventOrderRefund::class, EventType::SellerEventOrderRefund()],
            [OrderReturnReceived::class, SellerEventOrderReturnReceived::class, EventType::SellerOrderReturnReceived()],
        ];
    }

    /**
     * @dataProvider eventTestCasesProvider
     * @param $expectation
     * @param $eventModel
     * @param $eventTypeString
     * @throws Exception
     */
    public function testCanCreateEventFromContainer($expectation, $eventModel, $eventTypeString)
    {
        $containerMock = $this->createMock(EventContainer::class);
        $containerMock->expects($this->atLeastOnce())->method('getType')
            ->willReturn($eventTypeString);
        $containerMock->expects($this->atLeastOnce())->method('getEvent')
            ->willReturn($this->createStub($eventModel));

        $containerMock->expects($this->any())->method('getId')->willReturn(uniqid("id"));
        $containerMock->expects($this->any())->method('getCreatedAt')->willReturn(new DateTimeImmutable());

        $factory = new EventFactory();
        $this->assertInstanceOf($expectation, $factory->createFromEventContainer($containerMock));
    }

    public function testWillReturnNullOnUnknownEvent()
    {
        $containerMock = $this->createMock(EventContainer::class);
        $containerMock->expects($this->atLeastOnce())->method('getType')
            ->willReturn(new EventType('Foo.Mag.Bar'));
        $containerMock->expects($this->never())->method('getEvent');

        $factory = new EventFactory();
        $this->assertNull($factory->createFromEventContainer($containerMock));
    }
}
