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
use JTL\SCX\Lib\Channel\Client\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class SystemTestEvent extends AbstractEvent
{
    private SellerEventTest $event;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SellerEventTest $event,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SellerEventTest(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventTest
    {
        return $this->event;
    }
}
