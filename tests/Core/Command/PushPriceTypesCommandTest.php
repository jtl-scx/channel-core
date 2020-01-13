<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-16
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Client\Channel\Api\Price\PriceApi;
use JTL\SCX\Client\Channel\Api\Price\Response\CreatePriceTypeResponse;
use JTL\SCX\Client\Channel\Model\PriceType;
use JTL\SCX\Lib\Channel\MetaData\Price\PriceTypeList;
use JTL\SCX\Lib\Channel\MetaData\Price\PriceTypeLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class PushPriceTypesCommandTest
 * @package JTL\SCX\Lib\Channel\Core\Command
 *
 * @covers \JTL\SCX\Lib\Channel\Core\Command\PushPriceTypesCommand
 */
class PushPriceTypesCommandTest extends TestCase
{
    public function testCanPushDataToScx()
    {
        $defaultFilename = './config/priceDefinition.json';

        $priceId = uniqid("priceId", true);
        $priceList = $this->createPriceList($priceId);

        $returnMock = $this->createMock(CreatePriceTypeResponse::class);
        $returnMock->expects($this->atLeastOnce())->method('getStatusCode')->willReturn(201);

        $clientMock = $this->createMock(PriceApi::class);
        $clientMock->expects($this->atLeastOnce())->method('create')->willReturn($returnMock);

        $priceLoaderMock = $this->createMock(PriceTypeLoader::class);
        $priceLoaderMock->expects($this->once())->method('load')->with($defaultFilename)->willReturn($priceList);

        $command = new PushPriceTypesCommand($clientMock, $priceLoaderMock);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString($priceId, $commandTester->getDisplay());
        $this->assertStringNotContainsString('Error', $commandTester->getDisplay());
    }

    public function testCanGetUnexpectedStatusCode()
    {
        $returnMock = $this->createMock(CreatePriceTypeResponse::class);
        $returnMock->expects($this->atLeastOnce())->method('getStatusCode')->willReturn(400);

        $clientMock = $this->createMock(PriceApi::class);
        $clientMock->expects($this->atLeastOnce())->method('create')->willReturn($returnMock);

        $priceLoaderMock = $this->createMock(PriceTypeLoader::class);
        $priceLoaderMock->expects($this->once())
            ->method('load')
            ->willReturn($this->createPriceList(uniqid('priceList', true)));


        $command = new PushPriceTypesCommand($clientMock, $priceLoaderMock);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString('Error', $commandTester->getDisplay());
        $this->assertStringContainsString('400', $commandTester->getDisplay());
        $this->assertStringNotContainsString('successful', $commandTester->getDisplay());
    }

    public function testCanGetHandleException()
    {
        $exception = new \Exception('ErrorMsg');

        $clientMock = $this->createMock(PriceApi::class);
        $clientMock->expects($this->atLeastOnce())->method('create')->willThrowException($exception);

        $priceLoaderMock = $this->createMock(PriceTypeLoader::class);
        $priceLoaderMock->expects($this->once())
            ->method('load')
            ->willReturn($this->createPriceList(uniqid('priceList', true)));

        $command = new PushPriceTypesCommand($clientMock, $priceLoaderMock);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertStringContainsString('throwed a Exception', $commandTester->getDisplay());
        $this->assertStringContainsString('ErrorMsg', $commandTester->getDisplay());
        $this->assertStringNotContainsString('successful', $commandTester->getDisplay());
    }

    /**
     * @param string $priceId
     * @return array|PriceTypeList
     */
    private function createPriceList(string $priceId)
    {
        $priceMock = $this->createMock(PriceType::class);
        $priceMock->method('getPriceTypeId')->willReturn($priceId);
        $priceList = new PriceTypeList();
        $priceList[] = $priceMock;
        return $priceList;
    }
}
