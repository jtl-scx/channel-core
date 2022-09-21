<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\ChannelUpdate;
use JTL\SCX\Client\Request\ScxApiRequest;

class UpdateChannelRequest extends AbstractScxApiRequest
{
    private ChannelUpdate $channelUpdate;

    public function __construct(ChannelUpdate $channelUpdate)
    {
        $this->channelUpdate = $channelUpdate;
    }

    public function getChannelUpdate(): ChannelUpdate
    {
        return $this->channelUpdate;
    }

    public function getUrl(): string
    {
        return '/v1/channel';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_PATCH;
    }

    public function getBody(): string
    {
        return (string)$this->getChannelUpdate();
    }
}
