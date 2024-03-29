<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderCancellationRequest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderCancellationRequestEvent extends AbstractEvent
{
    private SellerEventOrderCancellationRequest $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderCancellationRequest $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerOrderCancellationRequest(), $internalEventId);
        $this->event = $event;
    }

    /**
     * @return SellerEventOrderCancellationRequest
     */
    public function getEvent(): SellerEventOrderCancellationRequest
    {
        return $this->event;
    }
}
