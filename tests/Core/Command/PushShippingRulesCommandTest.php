<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-08-17
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\CreateShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Response\CreateShippingRulesResponse;
use JTL\SCX\Lib\Channel\Client\Api\Meta\ShippingRulesApi;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Model\AttributeType;
use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;
use JTL\SCX\Lib\Channel\Client\Model\ShippingAttributeLevel;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\GlobalShippingAttributeLoader;
use JTL\SCX\Lib\Channel\Helper\FileHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Command\PushShippingRulesCommand
 */
class PushShippingRulesCommandTest extends TestCase
{
    public function testCanPushDataToScx(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedCarrierList": [{"carrierId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->with($this->callback(
                function (CreateShippingRulesRequest $request) {
                    return (
                        $request->getShippingRules()->getSupportedCarrierList()[0]->getCarrierId() === 'FooBar'
                        && $request->getShippingRules()->getSupportedCarrierList()[0]->getDisplayName() === 'HerpDerp'
                    );
                }
            ))
            ->willReturn(new CreateShippingRulesResponse(201));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $this->emptyShippingAttributeLoader()
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(0, $commandTester->execute(['filename' => $fileName]));
    }

    public function testPushesChannelSpecificShippingAttributesTogetherWithCarriers(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedCarrierList": [{"carrierId": "FooBar", "displayName": "HerpDerp"}]}';

        $attribute = new ChannelSpecificShippingAttribute([
            'attributeId' => 'returnAddressCarrierId',
            'displayName' => 'Rücksendelager',
            'type' => AttributeType::ENUM(),
            'level' => ShippingAttributeLevel::SHIPMENT(),
        ]);

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->with($this->callback(
                static function (CreateShippingRulesRequest $request) use ($attribute): bool {
                    return $request->getShippingRules()->getChannelSpecificAttributeList() === [$attribute]
                        && $request->getShippingRules()->getSupportedCarrierList()[0]->getCarrierId() === 'FooBar';
                }
            ))
            ->willReturn(new CreateShippingRulesResponse(201));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->method('readContent')->with($fileName)->willReturn($jsonData);

        $loaderStub = $this->createStub(GlobalShippingAttributeLoader::class);
        $loaderStub->method('load')->willReturn([$attribute]);

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $loaderStub
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(0, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsWhenFileDontExists(): void
    {
        $fileName = uniqid('fileName', true);

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->never())->method('create');
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(false);

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $this->emptyShippingAttributeLoader()
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(1, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsWhenNoCarrierExists(): void
    {
        $fileName = uniqid('fileName', true);

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->never())->method('create');
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn('');

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $this->emptyShippingAttributeLoader()
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(2, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsIfRequestFails(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedCarrierList": [{"carrierId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->willThrowException($this->createStub(RequestFailedException::class));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $this->emptyShippingAttributeLoader()
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(3, $commandTester->execute(['filename' => $fileName]));
    }

    public function testFailsIfRequestRetunStatus400(): void
    {
        $fileName = uniqid('fileName', true);
        $jsonData = '{"supportedCarrierList": [{"carrierId": "FooBar", "displayName": "HerpDerp"}]}';

        $clientMock = $this->createMock(ShippingRulesApi::class);
        $clientMock->expects($this->once())->method('create')
            ->willReturn(new CreateShippingRulesResponse(400));
        $fileLoaderMock = $this->createMock(FileHandler::class);
        $fileLoaderMock->expects($this->once())->method('isFile')->with($fileName)->willReturn(true);
        $fileLoaderMock->expects($this->once())->method('readContent')->with($fileName)->willReturn($jsonData);

        $command = new PushShippingRulesCommand(
            $clientMock,
            $fileLoaderMock,
            $this->createStub(ScxLogger::class),
            $this->emptyShippingAttributeLoader()
        );
        $commandTester = new CommandTester($command);
        $this->assertSame(4, $commandTester->execute(['filename' => $fileName]));
    }

    private function emptyShippingAttributeLoader(): GlobalShippingAttributeLoader
    {
        $loaderStub = $this->createStub(GlobalShippingAttributeLoader::class);
        $loaderStub->method('load')->willReturn([]);
        return $loaderStub;
    }
}
