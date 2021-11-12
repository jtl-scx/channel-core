<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/20
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class AttributesUpdateRequestEvent extends AbstractEvent
{
    private SellerEventSellerAttributesUpdateRequest $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventSellerAttributesUpdateRequest $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerMetaSellerAttributesUpdateRequest(), $internalEventId);
        $this->event = $event;
    }

    public static function seller(string $sellerId)
    {
        return new self(
            uniqid(),
            new DateTimeImmutable(),
            new SellerEventSellerAttributesUpdateRequest(['sellerId' => $sellerId])
        );
    }

    public function getEvent(): SellerEventSellerAttributesUpdateRequest
    {
        return $this->event;
    }
}
