<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2020/04/27
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

use JTL\SCX\Lib\Channel\Client\Model\SellerInventoryItem;
use PHPUnit\Framework\TestCase;

/**
 * Class SendReportRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Report\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Report\Request\SendReportRequest
 */
class SendReportRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $sellerInventoryItem = new SellerInventoryItem([
            'offerId' => 123,
            'sku' => '123',
            'quantity' => '1',
        ]);
        $reportId = uniqid('reportId', true);

        $request = new SendReportRequest($reportId, [$sellerInventoryItem], false);
        $this->assertSame('[{"offerId":123,"sku":"123","quantity":"1"}]', $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/report/{reportId}', $request->getUrl());
        $this->assertSame(['reportId' => $reportId], $request->getParams());
    }

    public function testCanBeCreatedForInventoryReport(): void
    {
        $reportId = '123';
        $item = new SellerInventoryItem([
            'offerId' => 123,
            'sku' => '123',
            'quantity' => '1',
        ]);
        $sut = SendReportRequest::forSellerInventoryReport($reportId, [$item], false);

        $this->assertSame('[{"offerId":123,"sku":"123","quantity":"1"}]', $sut->getBody());
        $this->assertSame('POST', $sut->getHttpMethod());
        $this->assertSame('/v1/channel/report/{reportId}', $sut->getUrl());
        $this->assertSame(['reportId' => $reportId], $sut->getParams());
    }

    public function testContentEncodingHeaderIsSetWhenUsingCompression(): void
    {
        $sut = SendReportRequest::forSellerInventoryReport('123', [], true);

        $this->assertSame(['Content-Encoding' => 'gzip'], $sut->getAdditionalHeaders());
        $gzipData = $sut->getBody();
        $this->assertEquals('[]', gzdecode($gzipData));
    }

    public function testContentEncodingHeaderIsNotSetWhenUsingNoCompression(): void
    {
        $sut = SendReportRequest::forSellerInventoryReport('123', [], false);

        $this->assertEmpty($sut->getAdditionalHeaders());
        $this->assertEquals('[]', $sut->getBody());
    }
}
