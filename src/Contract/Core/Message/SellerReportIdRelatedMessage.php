<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Message;

interface SellerReportIdRelatedMessage
{
    public function getSellerReportId(): string;
}
