<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-29
 */


namespace JTL\SCX\Lib\Channel\Contract\Core\Message;

interface RefundIdRelatedMessage
{
    public function getRefundId(): string;
}
