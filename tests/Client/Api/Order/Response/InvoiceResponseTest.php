<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/5/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Lib\Channel\Client\Api\Order\Response\InvoiceResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\InvoiceResponse
 */
class InvoiceResponseTest extends TestCase
{
    public function testResponseIsConsideredAsSuccessfulOnStatusCode200()
    {
        $sut = new InvoiceResponse(200, $this->createStub(StreamInterface::class));
        $this->assertTrue($sut->isSuccessful());
    }

    public function testItHasADocument()
    {
        $aDocument = $this->createStub(StreamInterface::class);
        $sut = new InvoiceResponse(200, $aDocument);
        $this->assertSame($aDocument, $sut->getDocument());
    }

    public function testResponseIsConsideredAsFailedOnStatusCodeNotEquals200()
    {
        $sut = new InvoiceResponse(123, $this->createStub(StreamInterface::class));
        $this->assertFalse($sut->isSuccessful());
    }
}
