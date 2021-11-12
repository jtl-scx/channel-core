<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Client\Api\Meta\PaymentRulesApi;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreatePaymentRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreatePaymentRulesResponse;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Command\PushPaymentRulesCommand
 */
class PushPaymentRulesCommandTest extends TestCase
{
    public function testCanPushDataToScx(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedPaymentMethodList": [{"paymentMethodId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(PaymentRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->with($this->callback(
                function (CreatePaymentRulesRequest $request) {
                    return (
                        $request->getPaymentRules()->getSupportedPaymentMethodList()[0]->getPaymentMethodId() === 'FooBar'
                        && $request->getPaymentRules()->getSupportedPaymentMethodList()[0]->getDisplayName() === 'HerpDerp'
                    );
                }
            ))
            ->willReturn(new CreatePaymentRulesResponse(201));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushPaymentRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(0, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsWhenFileDontExists(): void
    {
        $fileName = uniqid('fileName', true);

        $clientMock = $this->createMock(PaymentRulesApi::class);
        $clientMock->expects($this->never())->method('create');
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(false);

        $command = new PushPaymentRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(1, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsWhenNoPaymentMethodExists(): void
    {
        $fileName = uniqid('fileName', true);

        $clientMock = $this->createMock(PaymentRulesApi::class);
        $clientMock->expects($this->never())->method('create');
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn('');

        $command = new PushPaymentRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(2, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsIfRequestFails(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedPaymentMethodList": [{"paymentMethodId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(PaymentRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushPaymentRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(3, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsIfRequestRetunStatus400(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedPaymentMethodList": [{"paymentMethodId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(PaymentRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->willReturn(new CreatePaymentRulesResponse(400));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushPaymentRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class)
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(4, $commandTester->execute(['filename' => $fileName]));
    }
}
