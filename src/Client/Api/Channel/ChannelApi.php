<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\GetChannelStatusRequest;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Request\UpdateChannelRequest;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Response\GetChannelStatusResponse;
use JTL\SCX\Lib\Channel\Client\Api\Channel\Response\UpdateChannelResponse;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Model\ChannelStatus;
use JTL\SCX\Client\Exception\RequestFailedException;

class ChannelApi
{
    private AuthAwareApiClient $client;
    private ChannelApiResponseDeserializer $responseDeserializer;

    public function __construct(
        AuthAwareApiClient $client,
        ChannelApiResponseDeserializer $responseDeserializer = null
    ) {
        $this->client = $client;
        $this->responseDeserializer = $responseDeserializer ?? new ChannelApiResponseDeserializer();
    }

    /**
     * @param UpdateChannelRequest $channelRequest
     * @return UpdateChannelResponse
     * @throws RequestFailedException
     * @throws GuzzleException
     */
    public function update(UpdateChannelRequest $channelRequest): UpdateChannelResponse
    {
        $response = $this->client->request($channelRequest);
        return new UpdateChannelResponse($response->getStatusCode());
    }

    /**
     * @param GetChannelStatusRequest $request
     * @return GetChannelStatusResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function getStatus(GetChannelStatusRequest $request): GetChannelStatusResponse
    {
        $response = $this->client->request($request);
        /** @var ChannelStatus $model */
        $model = $this->responseDeserializer->deserialize($response, ChannelStatus::class);

        return new GetChannelStatusResponse($model->getChannel(), $response->getStatusCode());
    }
}
