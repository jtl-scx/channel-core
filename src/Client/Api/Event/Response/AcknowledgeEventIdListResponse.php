<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class AcknowledgeEventIdListResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() === 204;
    }
}
