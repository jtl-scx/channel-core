<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/5/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\InvoiceMetaData;
use JTL\SCX\Client\Request\Multipart\MultipartFormDataRequest;
use JTL\SCX\Client\Request\Multipart\MultipartParameter;
use Psr\Http\Message\StreamInterface;

class UploadInvoiceRequest extends AbstractScxApiRequest implements MultipartFormDataRequest
{
    private InvoiceMetaData $metaData;

    /**
     * @var string|StreamInterface|resource $document
     */
    private $document;

    /**
     * UploadInvoiceRequest constructor.
     * @param InvoiceMetaData $metaData
     * @param string|StreamInterface|resource $document
     */
    public function __construct(InvoiceMetaData $metaData, $document)
    {
        $this->metaData = $metaData;
        $this->document = $document;
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/invoice';
    }

    public function getHttpMethod(): string
    {
        return AbstractScxApiRequest::HTTP_METHOD_POST;
    }

    public function buildMultipartBody(): array
    {
        return [
            new MultipartParameter('invoice', (string)$this->metaData),
            new MultipartParameter('document', $this->document)
        ];
    }
}
