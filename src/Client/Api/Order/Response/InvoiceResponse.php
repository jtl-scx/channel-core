<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/5/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Client\Response\AbstractResponse;
use Psr\Http\Message\StreamInterface;

class InvoiceResponse extends AbstractResponse
{
    private StreamInterface $document;

    public function __construct(int $statusCode, StreamInterface $document)
    {
        parent::__construct($statusCode);
        $this->document = $document;
    }

    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 200;
    }

    public function getDocument(): StreamInterface
    {
        return $this->document;
    }
}
