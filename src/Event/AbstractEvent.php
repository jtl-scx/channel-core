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
    protected string $clientVersion;
    protected EventType $type;
    private ?int $retryCount;

    public function __construct(
        string $id,
        string $clientVersion,
        DateTimeImmutable $createdAt,
        EventType $type,
        string $internalEventId = null,
        int $delay = null,
        int $retryDelay = null,
        int $retryCount = null,
    ) {
        parent::__construct(
            messageId: $internalEventId,
            createdAt: $createdAt,
            delay: $delay ?? 0,
            retryDelay: $retryDelay ?? 120
        );
        $this->retryCount = $retryCount;
        $this->id = $id;
        $this->type = $type;
    }

    public function getRetryCount(): int
    {
        return $this->retryCount ?? parent::getRetryCount();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClientVersion(): string
    {
        return $this->clientVersion;
    }

    public function getType(): EventType
    {
        return $this->type;
    }
}
