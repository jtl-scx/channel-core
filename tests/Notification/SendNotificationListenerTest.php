<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use JTL\SCX\Client\Channel\Api\Notification\NotificationApi;
use JTL\SCX\Client\Channel\Api\Notification\Request\NotificationRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use PHPUnit\Framework\TestCase;

/**
 * Class SendNotificationListenerTest
 * @covers \JTL\SCX\Lib\Channel\Notification\SendNotificationListener
 */
class SendNotificationListenerTest extends TestCase
{
    public function testCanSendNotification()
    {
        $notificationApiMock = $this->createMock(NotificationApi::class);
        $notificationApiMock->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(NotificationRequest::class));

        $listener = new SendNotificationListener($notificationApiMock, $this->createStub(ScxLogger::class));

        $message = SendNotificationMessage::info(
            'seller',
            'a message',
            NotificationReference::offer('123')
        );

        $listener->sendNotification($message);
    }
}
