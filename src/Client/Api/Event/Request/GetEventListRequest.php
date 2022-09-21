<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-10
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class GetEventListRequest extends AbstractScxApiRequest
{
    public function getUrl(): string
    {
        return '/v1/channel/event';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
