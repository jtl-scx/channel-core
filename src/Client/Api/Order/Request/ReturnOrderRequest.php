<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 4/29/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\ReturnAnnouncement;

class ReturnOrderRequest extends AbstractScxApiRequest
{
    private ReturnAnnouncement $returnAnnouncement;

    public function __construct(ReturnAnnouncement $returnAnnouncement)
    {
        $this->returnAnnouncement = $returnAnnouncement;
    }

    public function getUrl(): string
    {
        return '/v1/channel/order/return';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_POST;
    }

    public function getBody(): ?string
    {
        return (string)$this->returnAnnouncement;
    }
}
