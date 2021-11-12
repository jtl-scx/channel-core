<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Notification\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class NotificationResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return parent::getStatusCode() === 201;
    }
}
