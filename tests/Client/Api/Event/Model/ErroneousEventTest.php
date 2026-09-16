<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Event\Model\ErroneousEvent::class)]
class ErroneousEventTest extends TestCase
{
    #[Test]
    public function it_may_have_a_Exception_Instance(): void
    {
        $exception = new Exception();
        $sut = new ErroneousEvent('eg', 'al', $exception);
        self::assertSame($exception, $sut->getException());

        $sut = new ErroneousEvent('eg', 'al', null);
        self::assertNull($sut->getException());
    }

    #[Test]
    public function it_has_affected_event_as_Json(): void
    {
        $eventJson = 'jsonString';
        $sut = new ErroneousEvent($eventJson, 'wurscht', null);
        self::assertSame($eventJson, $sut->getEventJson());
    }

    #[Test]
    public function it_has_error_message(): void
    {
        $errorMessage = 'THE_ERROR_MESSAGE';
        $sut = new ErroneousEvent('jsonString', $errorMessage, null);
        self::assertSame($errorMessage, $sut->getErrorMessage());
    }
}
