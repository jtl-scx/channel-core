<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event;

use DateTimeImmutable;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Lib\Channel\Client\Event\EventType;

abstract class AbstractEvent extends AbstractAmqpTransportableMessage
{
    protected string $id;
    protected EventType $type;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        EventType $type,
        string $internalEventId = null
    ) {
        parent::__construct($internalEventId, $createdAt);
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): EventType
    {
        return $this->type;
    }
}
