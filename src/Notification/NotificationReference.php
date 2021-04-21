<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use JTL\SCX\Client\Channel\Model\ChannelNotificationReferenceType as Ref;

class NotificationReference
{
    private string $type;
    private string $id;

    public function __construct(string $type, string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    public static function offer(string $id): NotificationReference
    {
        return new self(Ref::OFFER, $id);
    }

    public static function channelOffer(string $id): NotificationReference
    {
        return new self(Ref::CHANNELOFFER, $id);
    }

    public static function orderItemId(string $orderItemId): NotificationReference
    {
        return new self(Ref::ORDERITEMID, $orderItemId);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
