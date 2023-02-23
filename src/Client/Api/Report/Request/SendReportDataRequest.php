<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

class SendReportDataRequest extends SendReportRequest
{
    public function getUrl(): string
    {
        return '/v1/channel/report/{reportId}/data';
    }
}
