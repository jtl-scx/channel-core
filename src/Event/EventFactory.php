<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event;

use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
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

class EventFactory
{
    public function createFromEventContainer(EventContainer $eventContainer): ?AbstractEvent
    {
        switch ($eventContainer->getType()) {
            case EventType::SystemNotification():
                $eventClass = SystemNotificationEvent::class;
                break;
            case EventType::SellerEventTest():
                $eventClass = SystemTestEvent::class;
                break;
            case EventType::SellerOrderAccept():
                $eventClass = OrderAcceptEvent::class;
                break;
            case EventType::SellerOrderShipping():
                $eventClass = OrderShippingEvent::class;
                break;
            case EventType::SellerOrderPayment():
                $eventClass = OrderPaymentEvent::class;
                break;
            case EventType::SellerOrderCancellationRequest():
                $eventClass = OrderCancellationRequestEvent::class;
                break;
            case EventType::SellerOfferEnd():
                $eventClass = OfferEndEvent::class;
                break;
            case EventType::SellerOfferNew():
                $eventClass = OfferNewEvent::class;
                break;
            case EventType::SellerOfferUpdate():
                $eventClass = OfferUpdateEvent::class;
                break;
            case EventType::SellerOfferStockUpdate():
                $eventClass = OfferStockUpdateEvent::class;
                break;
            case EventType::SellerOfferPriceUpdate():
                $eventClass = OfferPriceUpdateEvent::class;
                break;
            case EventType::SellerReportRequest():
                $eventClass = ReportRequestEvent::class;
                break;
            case EventType::SellerChannelUnlinked():
                $eventClass = ChannelUnlinkedEvent::class;
                break;
            case EventType::SellerMetaSellerAttributesUpdateRequest():
                $eventClass = AttributesUpdateRequestEvent::class;
                break;
            case EventType::SellerOrderCancellationAccept():
                $eventClass = OrderCancellationAcceptedEvent::class;
                break;
            case EventType::SellerOrderCancellationDenied():
                $eventClass = OrderCancellationDeniedEvent::class;
                break;
            case EventType::SellerEventOrderInvoice():
                $eventClass = OrderInvoiceEvent::class;
                break;
            case EventType::SellerEventOrderRefund():
                $eventClass = OrderRefundEvent::class;
                break;
            case EventType::SellerOrderReturnReceived():
                $eventClass = OrderReturnReceived::class;
                break;
            default:
                return null;
        }

        /** @phpstan-ignore-next-line */
        return new $eventClass($eventContainer->getId(), $eventContainer->getCreatedAt(), $eventContainer->getEvent());
    }
}
