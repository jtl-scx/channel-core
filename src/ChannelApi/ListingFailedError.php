<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

class ListingFailedError
{
    private string $code;
    private string $message;
    private ?string $longMessage;

    public function __construct(string $code, string $message, string $longMessage = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->longMessage = $longMessage;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLongMessage(): ?string
    {
        return $this->longMessage;
    }
}