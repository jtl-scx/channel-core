<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/19
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Response;

use JTL\SCX\Lib\Channel\Client\Api\Event\Model\ErroneousEvent;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use JTL\SCX\Client\Response\AbstractResponse;

class GetSellerEventListResponse extends AbstractResponse
{
    /**
     * @var EventContainerList
     */
    private EventContainerList $eventList;

    /**
     * @var array<ErroneousEvent>
     */
    private array $errorEvents;

    /**
     * GetSellerEventListResponse constructor.
     * @param EventContainerList $eventList
     * @param int $statusCode
     * @param array<ErroneousEvent> $errorEvents
     */
    public function __construct(EventContainerList $eventList, int $statusCode, array $errorEvents = [])
    {
        parent::__construct($statusCode);
        $this->eventList = $eventList;
        $this->errorEvents = $errorEvents;
    }

    /**
     * @return EventContainerList
     */
    public function getEventList(): EventContainerList
    {
        return $this->eventList;
    }

    /**
     * @return array<ErroneousEvent>
     */
    public function getErroneousEvents(): array
    {
        return $this->errorEvents;
    }
}
