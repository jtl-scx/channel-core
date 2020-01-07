<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class SystemNotificationEvent extends AbstractEvent
{

    /**
     * @var SystemEventNotification
     */
    private $event;

    /**
     * SystemNotificationEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SystemEventNotification $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SystemEventNotification $event)
    {
        parent::__construct($id, $createdAt, EventType::SYSTEM__NOTIFICATION());
        $this->event = $event;
    }

    /**
     * @return SystemEventNotification
     */
    public function getEvent(): SystemEventNotification
    {
        return $this->event;
    }
}
