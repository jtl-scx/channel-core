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
use JTL\SCX\Lib\Channel\Client\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class SystemNotificationEvent extends AbstractEvent
{
    private SystemEventNotification $event;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        SystemEventNotification $event,
        string|null $internalEventId = null
    ) {
        parent::__construct($id, $clientVersion, $createdAt, EventType::SystemNotification(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SystemEventNotification
    {
        return $this->event;
    }
}
