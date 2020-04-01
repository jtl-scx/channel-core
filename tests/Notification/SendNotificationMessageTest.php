<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Notification\SendNotificationMessage
 */
class SendNotificationMessageTest extends TestCase
{
    public function testCanCreateWithSeverityLevelInfo()
    {
        $n = SendNotificationMessage::info('123', 'a message');
        $this->assertTrue($n->getSeverity()->equals(Severity::INFO()));
    }

    public function testCanCreateWithSeverityLevelWarning()
    {
        $n = SendNotificationMessage::warning('123', 'a message');
        $this->assertTrue($n->getSeverity()->equals(Severity::WARNING()));
    }

    public function testCanCreateWithSeverityLevelError()
    {
        $n = SendNotificationMessage::error('123', 'a message');
        $this->assertTrue($n->getSeverity()->equals(Severity::ERROR()));
    }

    public function testCanReadSellerId()
    {
        $testSeller = uniqid('testseller');
        $n = SendNotificationMessage::info($testSeller, 'a message');
        $this->assertEquals($testSeller, $n->getSellerId());
    }

    public function testCanReadMessage()
    {
        $testMessage = uniqid('message');
        $n = SendNotificationMessage::info('egal', $testMessage);
        $this->assertEquals($testMessage, $n->getMessage());
    }

    public function testCanReadSeverity()
    {
        $severity = Severity::INFO();
        $n = new SendNotificationMessage('egal', 'egal', $severity);
        $this->assertSame($severity, $n->getSeverity());
    }

    public function testCanReadReference()
    {
        $reference = NotificationReference::offer('123');
        $n = new SendNotificationMessage('egal', 'egal', Severity::INFO(), $reference);
        $this->assertSame($reference, $n->getReference());
    }

    public function testDefaultSeverityIsInfo()
    {
        $n = new SendNotificationMessage('egal', 'egal');
        $this->assertTrue($n->getSeverity()->equals(Severity::INFO()));
    }
}
