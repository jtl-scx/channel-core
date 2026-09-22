<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2026/09/22
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\InvoiceMetaData;
use JTL\SCX\Client\Request\Multipart\MultipartFormDataRequest;
use JTL\SCX\Client\Request\Multipart\MultipartParameter;

/**
 * Submits the invoice data for an order without any document (VCS / VCS Lite).
 */
class UploadInvoiceDataRequest extends AbstractScxApiRequest implements MultipartFormDataRequest
{
    public function __construct(private InvoiceMetaData $metaData)
    {
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/invoice-data';
    }

    public function getHttpMethod(): string
    {
        return AbstractScxApiRequest::HTTP_METHOD_POST;
    }

    public function buildMultipartBody(): array
    {
        return [
            new MultipartParameter('invoice', (string)$this->metaData)
        ];
    }
}
