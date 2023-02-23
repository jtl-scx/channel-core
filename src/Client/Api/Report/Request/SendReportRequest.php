<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2020/04/24
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Report\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\ObjectSerializer;
use JTL\SCX\Client\Request\ScxApiRequest;

/**
 * @deprecated
 */
class SendReportRequest extends AbstractScxApiRequest
{
    public function __construct(private readonly string $reportId, private readonly array $reportData, private readonly bool $enableCompression = true)
    {
    }

    public function getUrl(): string
    {
        return '/v1/channel/report/{reportId}';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }

    public function getParams(): array
    {
        return ['reportId' => $this->reportId];
    }

    public function getAdditionalHeaders(): array
    {
        if ($this->enableCompression) {
            return ['Content-Encoding' => 'gzip'];
        }

        return [];
    }

    public function getBody(): ?string
    {
        $body = json_encode(ObjectSerializer::sanitizeForSerialization($this->reportData));
        if ($this->enableCompression) {
            $body = gzencode($body);
        }
        return $body;
    }
}
