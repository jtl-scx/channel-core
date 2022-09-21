<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/23/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Notification;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\Notification\Request\NotificationRequest;
use JTL\SCX\Lib\Channel\Client\Api\Notification\Response\NotificationResponse;
use JTL\SCX\Client\Exception\RequestFailedException;

class NotificationApi
{
    private AuthAwareApiClient $apiClient;

    public function __construct(AuthAwareApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param NotificationRequest $request
     * @return NotificationResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function send(NotificationRequest $request): NotificationResponse
    {
        $response = $this->apiClient->request($request);
        return new NotificationResponse($response->getStatusCode());
    }
}
