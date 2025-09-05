<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Model;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventChannelUnlinked as ChannelUnlinked;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferEnd as OfferEnd;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferNew as OfferNew;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferPriceUpdate as PriceUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferStockUpdate as StockUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOfferUpdate as OfferUpdate;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationAccepted as CancellationAccept;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationDenied as CancellationDenied;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationRequest as CancellationRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderPayment as Payment;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderShipping as Shipping;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventReportRequest as ReportRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest as SellerAttributeUpdateRequest;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest as Test;
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification as Notification;

class EventContainer
{
    private string $id;
    private string $clientVersion;
    private \DateTimeImmutable $createdAt;
    private EventType $type;
    private $event;

    public function __construct(string $id, \DateTimeImmutable $createdAt, string $clientVersion, EventType $type, $event)
    {
        $this->id = $id;
        $this->clientVersion = $clientVersion;
        $this->createdAt = $createdAt;
        $this->type = $type;
        $this->event = $event;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClientVersion(): string
    {
        return $this->clientVersion;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getType(): EventType
    {
        return $this->type;
    }

    /**
     * @return Test|Notification|Shipping|Payment|OfferNew|OfferUpdate|OfferEnd|StockUpdate|PriceUpdate|ReportRequest|ChannelUnlinked|SellerAttributeUpdateRequest|CancellationAccept|CancellationDenied|CancellationRequest
     */
    public function getEvent()
    {
        return $this->event;
    }
}
