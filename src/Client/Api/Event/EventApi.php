<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Api\AuthAwareApiClient;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\ErroneousEvent;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\GetEventListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Response\AcknowledgeEventIdListResponse;
use JTL\SCX\Lib\Channel\Client\Api\Event\Response\GetSellerEventListResponse;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\JsonSerializer;

class EventApi
{
    private JsonSerializer $jsonSerializer;
    private AuthAwareApiClient $client;
    private ChannelApiResponseDeserializer $responseDeserializer;

    public function __construct(
        AuthAwareApiClient $client,
        JsonSerializer $jsonSerializer = null,
        ChannelApiResponseDeserializer $responseDeserializer = null
    ) {
        $this->client = $client;
        $this->jsonSerializer = $jsonSerializer ?? new JsonSerializer();
        $this->responseDeserializer = $responseDeserializer ?? new ChannelApiResponseDeserializer();
    }

    /**
     * @param GetEventListRequest|null $request
     * @return GetSellerEventListResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function get(GetEventListRequest $request = null): GetSellerEventListResponse
    {
        $responseData = $this->client->request($request ?? new GetEventListRequest());
        $data = $this->jsonSerializer->deserialize((string)$responseData->getBody(), false);
        $eventList = new EventContainerList();

        if (!isset($data->eventList)) {
            throw new \UnexpectedValueException('Missing eventList property in Api Response');
        }

        $errorEvents = [];
        foreach ($data->eventList as $event) {
            if (!isset($event->type, $event->id, $event->event, $event->createdAt)) {
                $eventJson = json_encode($event);
                $errorEvents[] = new ErroneousEvent($eventJson, "Invalid or missing properties", null);
                continue;
            }

            try {
                $eventType = new EventType($event->type);
                $eventData = is_array($event->event) ? null : $this->createEventByType($eventType, $event->event);

                $eventContainer = new EventContainer(
                    (string)$event->id,
                    new \DateTimeImmutable($event->createdAt),
                    $event->clientVersion ?? '',
                    $eventType,
                    $eventData
                );
                $eventList->add($eventContainer);
            } catch (\Throwable $exception) {
                $eventJson = json_encode($event);
                $errorEvents[] = new ErroneousEvent($eventJson, $exception->getMessage(), $exception);
                continue;
            }
        }

        return new GetSellerEventListResponse($eventList, $responseData->getStatusCode(), $errorEvents);
    }

    /**
     * @param AcknowledgeEventIdListRequest $request
     * @return AcknowledgeEventIdListResponse
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function ack(AcknowledgeEventIdListRequest $request): AcknowledgeEventIdListResponse
    {
        $response = $this->client->request($request);
        return new AcknowledgeEventIdListResponse($response->getStatusCode());
    }

    private function createEventByType(EventType $type, \stdClass $data): object
    {
        if ($type->isUnknownEventType()) {
            return $data;
        }
        return $this->responseDeserializer->deserializeObject($data, $type->getEventModelClass());
    }
}
