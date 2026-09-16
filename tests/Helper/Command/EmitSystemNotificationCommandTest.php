<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Helper\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;

#[CoversClass(\JTL\SCX\Lib\Channel\Helper\Command\EmitSystemNotificationCommand::class)]
class EmitSystemNotificationCommandTest extends AbstractEmitterCommandTestCaseHelper
{
    #[Test]
    public function it_emit_system_notification_event(): void
    {
        $testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        $json = <<<JSON
{
  "channel": "channel",
  "sellerId": "sellerId",
  "message": "Hello, Channel!",
  "severity": "INFO"
}

JSON;

        file_put_contents($testJsonFile, $json);
        $commandTest = $this->createSystemOfTest(
            EmitSystemNotificationCommand::class,
            $this->buildEmitterMock(SystemNotificationEvent::class)
        );

        $commandTest->execute([
            'jsonFile' => $testJsonFile,
            'sellerId' => uniqid('sellerId'),
        ]);
    }


}
