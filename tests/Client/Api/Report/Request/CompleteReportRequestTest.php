<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Client\Api\Report\Request\CompleteReportRequest
 */
class CompleteReportRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $reportId = uniqid('reportId', true);

        $request = new CompleteReportRequest($reportId);
        $this->assertSame('', $request->getBody());
        $this->assertSame('POST', $request->getHttpMethod());
        $this->assertSame('/v1/channel/report/{reportId}/completed', $request->getUrl());
        $this->assertSame(['reportId' => $reportId], $request->getParams());
    }
}
