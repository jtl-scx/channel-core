<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/06/04
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Client\Channel\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use JTL\SCX\Lib\Channel\Event\Seller\OrderAcceptEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class EmitOrderAcceptCommandTestenumValues
 * @package JTL\SCX\Lib\Channel\Helper\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Helper\Command\EmitOrderAcceptCommand
 */
class EmitOrderAcceptCommandTest extends TestCase
{
    public function testCanEmitOrderAcceptEvent(): void
    {
        $testJsonFile = sys_get_temp_dir() . '/' . __CLASS__ . '.json';
        $json = <<<JSON
{
    "sellerId": "334334343",
    "orderId": "4711",
    "orderAccepted": true
}
JSON;

        file_put_contents($testJsonFile, $json);

        $args = [
            'jsonFile' => $testJsonFile,
            'sellerId' => uniqid('sellerId')
        ];

        $environmentMock = $this->createMock(Environment::class);
        $emitterMock = $this->createMock(AmqpEmitter::class);
        $responseDeserializer = new ChannelApiResponseDeserializer();
        $logger = $this->createMock(ScxLogger::class);

        $emitterMock->expects($this->exactly(1))
            ->method('emit')
            ->with($this->isInstanceOf(OrderAcceptEvent::class));

        $command = new EmitOrderAcceptCommand(
            $environmentMock,
            new EventFactory(),
            $emitterMock,
            $responseDeserializer,
            $logger
        );

        $commandTest = new CommandTester($command);
        $commandTest->execute($args);
    }
}
