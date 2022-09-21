<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-10
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Client\Request\ScxApiRequest;

class GetChannelStatusRequest extends AbstractScxApiRequest
{
    public function getUrl(): string
    {
        return '/v1/channel';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_GET;
    }
}
