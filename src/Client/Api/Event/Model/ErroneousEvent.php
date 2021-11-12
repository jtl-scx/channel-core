<?php


namespace JTL\SCX\Lib\Channel\Client\Api\Event\Model;

class ErroneousEvent
{
    private ?\Throwable $exception;
    private string $eventJson;
    private string $errorMessage;

    public function __construct(string $eventJson, string $errorMessage, ?\Throwable $exception)
    {
        $this->eventJson = $eventJson;
        $this->errorMessage = $errorMessage;
        $this->exception = $exception;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }

    public function getEventJson(): string
    {
        return $this->eventJson;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
