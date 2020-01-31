<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event;


use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Channel\Helper\Event\EventType;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancelledEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderConfirmedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderPaymentEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;

class EventFactory
{
    public function createFromEventContainer(EventContainer $eventContainer): ?AbstractEvent
    {
        switch ($eventContainer->getType()) {
            case EventType::SystemNotification():
                $eventName = SystemNotificationEvent::class;
                break;
            case EventType::SellerEventTest():
                $eventName = SystemTestEvent::class;
                break;
            case EventType::SellerOrderConfirmed():
                $eventName = OrderConfirmedEvent::class;
                break;
            case EventType::SellerOrderShipping():
                $eventName = OrderShippingEvent::class;
                break;
            case EventType::SellerOrderPayment():
                $eventName = OrderPaymentEvent::class;
                break;
            case EventType::SellerOrderCancelled():
                $eventName = OrderCancelledEvent::class;
                break;
            case EventType::SellerOfferEnd():
                $eventName = OfferEndEvent::class;
                break;
            case EventType::SellerOfferNew():
                $eventName = OfferNewEvent::class;
                break;
            default:
                return null;
        }

        return new $eventName(
            $eventContainer->getId(),
            $eventContainer->getCreatedAt(),
            $eventContainer->getEvent()
        );
    }
}
