<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Emitter;

use GuzzleHttp\Exception\GuzzleException;
use JTL\Nachricht\Contract\Emitter\Emitter;
use JTL\SCX\Client\Channel\Api\Event\GetSellerEventListApi;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use JTL\SCX\Lib\Channel\Event\Seller\SystemEventEnum;
use Psr\Log\LoggerInterface;

class SellerEventEmitter
{
    /**
     * @var Emitter
     */
    private $emitter;

    /**
     * @var GetSellerEventListApi
     */
    private $getSellerEventListApi;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EventFactory
     */
    private $eventFactory;

    /**
     * SellerEventEmitter constructor.
     * @param Emitter $emitter
     * @param EventFactory $eventFactory
     * @param GetSellerEventListApi $getSellerEventListApi
     * @param LoggerInterface $logger
     */
    public function __construct(
        Emitter $emitter,
        EventFactory $eventFactory,
        GetSellerEventListApi $getSellerEventListApi,
        LoggerInterface $logger
    )
    {
        $this->emitter = $emitter;
        $this->eventFactory = $eventFactory;
        $this->getSellerEventListApi = $getSellerEventListApi;
        $this->logger = $logger;
    }

    /**
     * TODO: Improve logging
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function emit(): void
    {
        $response = $this->getSellerEventListApi->getEventList();

        foreach ($response->getEventList() as $eventContainer) {
            $event = $this->eventFactory->createFromEventContainer($eventContainer);
            if ($event === null) {
                $this->logger->warning("Event type '{$eventContainer->getType()}' could not be mapped");
                continue;
            }
            $this->emitter->emit($event);
            $this->logger->info("Emitted event '{$eventContainer->getId()}' of type '{$eventContainer->getType()}'");
        }
    }
}
