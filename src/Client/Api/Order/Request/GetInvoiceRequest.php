<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/5/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class GetInvoiceRequest extends AbstractScxApiRequest
{
    private string $documentId;

    public function __construct(string $documentId)
    {
        $this->documentId = $documentId;
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/invoice/{documentId}';
    }

    public function getParams(): array
    {
        return ['documentId' => $this->documentId];
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
