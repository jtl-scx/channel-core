<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/17/19
 */

namespace JTL\SCX\Lib\Channel\Client\Price;

use JTL\SCX\Lib\Channel\Client\Model\PriceContainer;
use JTL\SCX\Lib\Channel\Client\Model\QuantityPrice;
use PHPUnit\Framework\TestCase;

/**
 * Class PriceSelectorTest
 * @covers \JTL\SCX\Lib\Channel\Client\Price\PriceSelector
 */
class PriceSelectorTest extends TestCase
{
    public function testCanSelectPriceContainerByType()
    {
        $expectedType = PriceType::B2C();
        $priceContainerMock = $this->createMock(PriceContainer::class);
        $priceContainerMock->expects($this->once())->method('getId')->willReturn((string)$expectedType);
        $priceList = [
            [],
            null,
            1,
            'otto',
            ['id' => $expectedType],
            $this->createStub(PriceContainer::class),
            $this->createStub(PriceContainer::class),
            $priceContainerMock,
        ];
        $selector = new PriceSelector();
        $result = $selector->priceContainerByType($priceList, $expectedType);
        $this->assertInstanceOf(PriceContainer::class, $result);
        $this->assertSame($priceContainerMock, $result);
    }

    public function testReturnNullIfNoPriceTypeFound()
    {
        $expectedType = PriceType::B2C();
        $priceList = [
            [],
            null,
            1,
            'otto',
            ['id' => $expectedType],
            $this->createStub(PriceContainer::class),
            $this->createStub(PriceContainer::class)
        ];
        $selector = new PriceSelector();
        $result = $selector->priceContainerByType($priceList, $expectedType);
        $this->assertNull($result);
    }

    public function testMinimumQuantityPriceByType()
    {
        $expectedType = PriceType::B2C();

        $quantityPriceMock = $this->createMock(QuantityPrice::class);
        $quantityPriceMock->expects($this->atLeastOnce())->method('getQuantity')->willReturn('1.0');
        $quantityPriceHighQuantityMock = $this->createMock(QuantityPrice::class);
        $quantityPriceHighQuantityMock->expects($this->atLeastOnce())->method('getQuantity')->willReturn('99');
        $priceList = [
            $quantityPriceHighQuantityMock,
            $quantityPriceMock,
        ];

        $priceContainerMock = $this->createMock(PriceContainer::class);
        $priceContainerMock->expects($this->once())->method('getId')->willReturn((string)$expectedType);
        $priceContainerMock->expects($this->once())->method('getQuantityPriceList')->willReturn($priceList);
        $priceList = [
            $this->createStub(PriceContainer::class),
            $priceContainerMock,
        ];
        $selector = new PriceSelector();
        $result = $selector->minimumQuantityPriceByType($priceList, $expectedType);
        $this->assertInstanceOf(QuantityPrice::class, $result);
        $this->assertSame($quantityPriceMock, $result);
    }

    public function testCanSelectMinimumQuantityPriceWhenPriceListIsUnordered()
    {
        $expectedType = PriceType::B2C();

        $quantityPriceMock = $this->createMock(QuantityPrice::class);
        $quantityPriceMock->expects($this->atLeastOnce())->method('getQuantity')->willReturn('1.0');
        $quantityPriceHighQuantityMock = $this->createMock(QuantityPrice::class);
        $quantityPriceHighQuantityMock->expects($this->atLeastOnce())->method('getQuantity')->willReturn('99');
        $priceList = [
            $quantityPriceMock,
            $quantityPriceHighQuantityMock,
        ];

        $priceContainerMock = $this->createMock(PriceContainer::class);
        $priceContainerMock->expects($this->once())->method('getId')->willReturn((string)$expectedType);
        $priceContainerMock->expects($this->once())->method('getQuantityPriceList')->willReturn($priceList);
        $priceList = [
            $this->createStub(PriceContainer::class),
            $priceContainerMock,
        ];
        $selector = new PriceSelector();
        $result = $selector->minimumQuantityPriceByType($priceList, $expectedType);
        $this->assertInstanceOf(QuantityPrice::class, $result);
        $this->assertSame($quantityPriceMock, $result);
    }

    public function testWillReturnNullWhenNoPriceTypMatch()
    {
        $expectedType = PriceType::B2C();

        $priceContainerMock = $this->createMock(PriceContainer::class);
        $priceContainerMock->expects($this->once())->method('getId')->willReturn("FOO");
        $priceContainerMock->expects($this->never())->method('getQuantityPriceList');

        $priceList = [
            $this->createStub(PriceContainer::class),
            $priceContainerMock,
        ];
        $selector = new PriceSelector();
        $result = $selector->minimumQuantityPriceByType($priceList, $expectedType);
        $this->assertNull($result);
    }
}
