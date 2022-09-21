<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Emitter;

use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainerList;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use Psr\Log\LoggerInterface;
use Throwable;

class SellerEventEmitter
{
    private Emitter $emitter;
    private EventFactory $eventFactory;
    private LoggerInterface $logger;

    public function __construct(Emitter $emitter, EventFactory $eventFactory, LoggerInterface $logger)
    {
        $this->emitter = $emitter;
        $this->eventFactory = $eventFactory;
        $this->logger = $logger;
    }

    /**
     * @param EventContainerList $eventContainerList
     * @return array
     */
    public function emit(EventContainerList $eventContainerList): array
    {
        $emittedEventIdList = [];
        foreach ($eventContainerList as $eventContainer) {
            $event = null;
            try {
                $event = $this->eventFactory->createFromEventContainer($eventContainer);
            } catch (Throwable $e) {
                $this->logger->error($e->getMessage());
            }

            if ($event === null) {
                $this->logger->warning("Event {$eventContainer->getId()} of type '{$eventContainer->getType()}' could not be mapped");
                continue;
            }
            $this->emitter->emit($event);
            $this->logger->info("Emitted event '{$eventContainer->getId()}' of type '{$eventContainer->getType()}'");
            $emittedEventIdList[] = $eventContainer->getId();
        }

        return $emittedEventIdList;
    }
}
