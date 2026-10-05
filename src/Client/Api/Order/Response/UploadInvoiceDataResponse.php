<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2026/09/22
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class UploadInvoiceDataResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 201;
    }
}
