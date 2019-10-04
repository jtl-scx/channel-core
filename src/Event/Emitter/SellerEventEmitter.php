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
use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancelledEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderConfirmedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderPaymentEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;
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
     * SellerEventEnqueuer constructor.
     * @param Emitter $emitter
     * @param GetSellerEventListApi $getSellerEventListApi
     * @param LoggerInterface $logger
     */
    public function __construct(
        Emitter $emitter,
        GetSellerEventListApi $getSellerEventListApi,
        LoggerInterface $logger
    ) {
        $this->emitter = $emitter;
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
            $event = $this->createEvent($eventContainer);
            if ($event === null) {
                $this->logger->warning("Event type {$eventContainer->getType()} could not be mapped");
                continue;
            }
            $this->emitter->emit($event);
            $this->logger->info("Emitted event {$eventContainer->getId()} of type {$eventContainer->getType()}}");
        }
    }

    /**
     * @param EventContainer $eventContainer
     * @return AbstractEvent|null
     */
    private function createEvent(EventContainer $eventContainer): ?AbstractEvent
    {
        switch ($eventContainer->getType()) {
            case 'System:Notification':
                return new SystemNotificationEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'System:Test':
                return new SystemTestEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'Seller:Order.Confirmed':
                return new OrderConfirmedEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'Seller:Order.Shipping':
                return new OrderShippingEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'Seller:Order.Payment':
                return new OrderPaymentEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'Seller:Order.Cancelled':
                return new OrderCancelledEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
            case 'Seller:Offer.End':
                return new OfferEndEvent(
                    $eventContainer->getId(),
                    $eventContainer->getCreatedAt(),
                    $eventContainer->getType(),
                    $eventContainer->getEvent()
                );
        }

        return null;
    }
}
