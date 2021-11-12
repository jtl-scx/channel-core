<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/6/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class UploadInvoiceResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
