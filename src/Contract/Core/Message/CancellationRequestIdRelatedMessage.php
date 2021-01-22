<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Message;

interface CancellationRequestIdRelatedMessage
{
    public function getCancellationRequestId(): string;
}