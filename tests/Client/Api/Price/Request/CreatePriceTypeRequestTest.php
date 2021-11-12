<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Price\Request;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\PriceType;

/**
 * Class CreatePriceTypeRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Price\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Price\Request\CreatePriceTypeRequest
 */
class CreatePriceTypeRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $bodyStr =uniqid('body', true);
        $priceTypeMock = $this->createMock(PriceType::class);
        $priceTypeMock->expects($this->atLeastOnce())->method('__toString')->willReturn($bodyStr);

        $request = new CreatePriceTypeRequest($priceTypeMock);
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/price', $request->getUrl());
    }
}
