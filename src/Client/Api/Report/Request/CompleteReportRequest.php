<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

use JTL\SCX\Client\Request\ScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;

class CompleteReportRequest extends AbstractScxApiRequest
{
    public function __construct(private readonly string $reportId)
    {
    }

    public function getUrl(): string
    {
        return '/v1/channel/report/{reportId}/completed';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }

    public function getParams(): array
    {
        return ['reportId' => $this->reportId];
    }
}
