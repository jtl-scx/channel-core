<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 4/1/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use InvalidArgumentException;
use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Notification\SendNotificationMessage;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \JTL\SCX\Lib\Channel\Helper\Command\EmitChannelNotificationCommand
 */
class EmitChannelNotificationCommandTestCaseHelper extends AbstractEmitterCommandTestCaseHelper
{
    public function testCanEmitChannelNotification()
    {
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message')
        ];
        $emitterMock = $this->createEmitterMock();
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'SendNotificationMessage with severity INFO emitted',
            $out
        );
    }

    public function testCanEmitChannelNotificationWarning()
    {
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message'),
            '--warning' => null
        ];
        $emitterMock = $this->createEmitterMock();
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'SendNotificationMessage with severity WARNING emitted',
            $out
        );
    }

    public function testCanEmitChannelNotificationError()
    {
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message'),
            '--error' => null
        ];
        $emitterMock = $this->createEmitterMock();
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'SendNotificationMessage with severity ERROR emitted',
            $out
        );
    }

    public function testCanEmitChannelNotificationWithOfferReference()
    {
        $testReferenceId = uniqid('referenceId');
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message'),
            '--offerId' => $testReferenceId
        ];
        $emitterMock = $this->createEmitterMock();
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'OFFER = ' . $testReferenceId,
            $out
        );
    }

    public function testCanEmitChannelNotificationWithOrderItemIdReference()
    {
        $testReferenceId = uniqid('referenceId');
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message'),
            '--orderItemId' => $testReferenceId
        ];
        $emitterMock = $this->createEmitterMock();
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'ORDERITEMID = ' . $testReferenceId,
            $out
        );
    }

    public function testThereCanOnlyOneReferenceAtATime()
    {
        $testReferenceId = uniqid('referenceId');
        $args = [
            'sellerId' => uniqid('seller'),
            'message' => uniqid('message'),
            '--offerId' => $testReferenceId,
            '--orderItemId' => $testReferenceId,
        ];
        $emitterMock = $this->createEmitterMock(0);

        $this->expectException(InvalidArgumentException::class);
        $out = $this->buildAndRunCommand($emitterMock, $args);

        $this->assertStringContainsString(
            'ORDERITEMID = ' . $testReferenceId,
            $out
        );
    }

    /**
     * @param int $expectsToEmit
     * @return Emitter|MockObject
     */
    private function createEmitterMock($expectsToEmit = 1)
    {
        $emitterMock = $this->createMock(Emitter::class);
        $emitterMock->expects($this->exactly($expectsToEmit))
            ->method('emit')
            ->with($this->isInstanceOf(SendNotificationMessage::class));
        return $emitterMock;
    }

    /**
     * @param $emitterMock
     * @param array $args
     * @return string
     */
    private function buildAndRunCommand($emitterMock, array $args): string
    {
        $emitterCmd = new EmitChannelNotificationCommand(
            $emitterMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($emitterCmd);
        $commandTester->execute($args);
        return $commandTester->getDisplay();
    }
}
