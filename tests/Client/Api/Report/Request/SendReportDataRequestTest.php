<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

use JTL\SCX\Lib\Channel\Client\Model\SellerInventoryItem;
use PHPUnit\Framework\TestCase;

/**
 * Class SendReportDataRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Report\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Report\Request\SendReportRequest
 */
class SendReportDataRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $sellerInventoryItem = new SellerInventoryItem([
            'offerId' => 123,
            'sku' => '123',
            'quantity' => '1',
        ]);
        $reportId = uniqid('reportId', true);

        $request = new SendReportDataRequest($reportId, [$sellerInventoryItem], false);
        $this->assertSame('[{"offerId":123,"sku":"123","quantity":"1"}]', $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/report/{reportId}/data', $request->getUrl());
        $this->assertSame(['reportId' => $reportId], $request->getParams());
    }

    public function testContentEncodingHeaderIsSetWhenUsingCompression(): void
    {
        $sut = new SendReportDataRequest('123', [], true);

        $this->assertSame(['Content-Encoding' => 'gzip'], $sut->getAdditionalHeaders());
        $gzipData = $sut->getBody();
        $this->assertEquals('[]', gzdecode($gzipData));
    }

    public function testContentEncodingHeaderIsNotSetWhenUsingNoCompression(): void
    {
        $sut = new SendReportDataRequest('123', [], false);

        $this->assertEmpty($sut->getAdditionalHeaders());
        $this->assertEquals('[]', $sut->getBody());
    }
}
