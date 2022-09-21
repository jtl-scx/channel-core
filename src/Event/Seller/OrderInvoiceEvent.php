<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/7/21
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventOrderInvoice;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class OrderInvoiceEvent extends AbstractEvent
{
    private SellerEventOrderInvoice $eventOrderInvoice;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventOrderInvoice $eventOrderInvoice,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerEventOrderInvoice(), $internalEventId);
        $this->eventOrderInvoice = $eventOrderInvoice;
    }

    public function getEvent(): SellerEventOrderInvoice
    {
        return $this->eventOrderInvoice;
    }
}
