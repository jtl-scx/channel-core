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
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderInvoice;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderRefund;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderReturnReceived;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventReportRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTypeList as Event;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use MyCLabs\Enum\Enum;

/**
 * Class EventType
 * @method static EventType Unknown()
 * @method static EventType SystemNotification()
 * @method static EventType SellerEventTest()
 * @method static EventType SellerOrderAccept()
 * @method static EventType SellerOrderShipping()
 * @method static EventType SellerOrderPayment()
 * @method static EventType SellerOrderCancellationRequest()
 * @method static EventType SellerOfferNew()
 * @method static EventType SellerOfferUpdate()
 * @method static EventType SellerOfferEnd()
 * @method static EventType SellerOfferStockUpdate()
 * @method static EventType SellerOfferPriceUpdate()
 * @method static EventType SellerReportRequest()
 * @method static EventType SellerChannelUnlinked()
 * @method static EventType SellerMetaSellerAttributesUpdateRequest()
 * @method static EventType SellerOrderCancellationAccept()
 * @method static EventType SellerOrderCancellationDenied()
 * @method static EventType SellerEventOrderInvoice()
 * @method static EventType SellerEventOrderRefund()
 * @method static EventType SellerOrderReturnReceived()
 *
 * @psalm-immutable
 */
class EventType extends Enum
{
    public const Unknown = 'unknown';
    public const SellerEventTest = Event::SYSTEMTEST;
    public const SystemNotification = Event::SYSTEMNOTIFICATION;
    public const SellerOrderAccept = Event::SELLERORDER_ACCEPTED;
    public const SellerOrderShipping = Event::SELLERORDER_SHIPPING;
    public const SellerOrderPayment = Event::SELLERORDER_PAYMENT;
    public const SellerOfferNew = Event::SELLEROFFER_NEW;
    public const SellerOfferUpdate = Event::SELLEROFFER_UPDATE;
    public const SellerOfferEnd = Event::SELLEROFFER_END;
    public const SellerOfferStockUpdate = Event::SELLEROFFER_STOCK_UPDATE;
    public const SellerOfferPriceUpdate = Event::SELLEROFFER_PRICE_UPDATE;
    public const SellerReportRequest = Event::SELLERREPORT_REQUEST;
    public const SellerChannelUnlinked = Event::SELLERCHANNEL_UNLINKED;
    public const SellerMetaSellerAttributesUpdateRequest = Event::SELLERMETA_SELLER_ATTRIBUTES_UPDATE_REQUEST;
    public const SellerOrderCancellationAccept = Event::SELLERORDER_CANCELLATION_ACCEPTED;
    public const SellerOrderCancellationDenied = Event::SELLERORDER_CANCELLATION_DENIED;
    public const SellerOrderCancellationRequest = Event::SELLERORDER_CANCELLATION_REQUEST;
    public const SellerEventOrderInvoice = Event::SELLERORDER_INVOICE;
    public const SellerEventOrderRefund = Event::SELLERORDER_REFUND;
    public const SellerOrderReturnReceived = Event::SELLERORDER_RETURN_RECEIVED;


    /**
     * EventType constructor.
     * @psalm-suppress MissingImmutableAnnotation
     * @param mixed $value
     */
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (\UnexpectedValueException $e) {
            parent::__construct(self::Unknown);
        }
    }

    public function getEventModelClass(): string
    {
        switch ($this) {
            case $this::SellerEventTest():
                return SellerEventTest::class;
            case $this::SystemNotification():
                return SystemEventNotification::class;
            case $this::SellerOrderAccept():
                return SellerEventOrderAccept::class;
            case $this::SellerOrderShipping():
                return SellerEventOrderShipping::class;
            case $this::SellerOrderPayment():
                return SellerEventOrderPayment::class;
            case $this::SellerOfferNew():
                return SellerEventOfferNew::class;
            case $this::SellerOfferUpdate():
                return SellerEventOfferUpdate::class;
            case $this::SellerOfferEnd():
                return SellerEventOfferEnd::class;
            case $this::SellerOfferStockUpdate():
                return SellerEventOfferStockUpdate::class;
            case $this::SellerOfferPriceUpdate():
                return SellerEventOfferPriceUpdate::class;
            case $this::SellerReportRequest():
                return SellerEventReportRequest::class;
            case $this::SellerChannelUnlinked():
                return SellerEventChannelUnlinked::class;
            case $this::SellerMetaSellerAttributesUpdateRequest():
                return SellerEventSellerAttributesUpdateRequest::class;
            case $this::SellerOrderCancellationAccept():
                return SellerEventOrderCancellationAccepted::class;
            case $this::SellerOrderCancellationDenied():
                return SellerEventOrderCancellationDenied::class;
            case $this::SellerOrderCancellationRequest():
                return SellerEventOrderCancellationRequest::class;
            case $this::SellerEventOrderInvoice():
                return SellerEventOrderInvoice::class;
            case $this::SellerEventOrderRefund():
                return SellerEventOrderRefund::class;
            case $this::SellerOrderReturnReceived():
                return SellerEventOrderReturnReceived::class;
        }

        return \stdClass::class;
    }

    public function isUnknownEventType(): bool
    {
        return $this->getEventModelClass() === \stdClass::class;
    }
}
