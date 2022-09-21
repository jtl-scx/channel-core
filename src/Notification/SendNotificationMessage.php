<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/16/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;

class SendNotificationMessage extends AbstractAmqpTransportableMessage
{
    private string $sellerId;
    private string $message;
    private Severity $severity;
    private ?NotificationReference $reference;

    public function __construct(
        string $sellerId,
        string $message,
        Severity $severity = null,
        NotificationReference $reference = null,
        string $messageId = null
    ) {
        parent::__construct($messageId);

        $this->sellerId = $sellerId;
        $this->message = $message;
        $this->severity = $severity ?? Severity::INFO();
        $this->reference = $reference;
    }

    public static function info(
        string $sellerId,
        string $message,
        NotificationReference $reference = null,
        string $messageId = null
    ): SendNotificationMessage {
        return new self($sellerId, $message, Severity::INFO(), $reference, $messageId);
    }

    public static function warning(
        string $sellerId,
        string $message,
        NotificationReference $reference = null,
        string $messageId = null
    ): SendNotificationMessage {
        return new self($sellerId, $message, Severity::WARNING(), $reference, $messageId);
    }

    public static function error(
        string $sellerId,
        string $message,
        NotificationReference $reference = null,
        string $messageId = null
    ): SendNotificationMessage {
        return new self($sellerId, $message, Severity::ERROR(), $reference, $messageId);
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSeverity(): Severity
    {
        return $this->severity;
    }

    public function getReference(): ?NotificationReference
    {
        return $this->reference;
    }
}
