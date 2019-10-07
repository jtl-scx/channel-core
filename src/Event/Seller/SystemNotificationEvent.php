<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class SystemNotificationEvent extends AbstractEvent
{

    /**
     * @var SystemEventNotification
     */
    private $event;

    /**
     * SystemNotificationEvent constructor.
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $type
     * @param SystemEventNotification $event
     */
    public function __construct(
        string $id,
        \DateTimeImmutable $createdAt,
        string $type,
        SystemEventNotification $event
    ) {
        parent::__construct($id, $createdAt, $type);
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
