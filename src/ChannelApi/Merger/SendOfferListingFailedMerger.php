<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\ChannelApi\Merger;

use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;

class SendOfferListingFailedMerger
{
    /**
     * Will return a merged SendOfferListingFailedMessage if a previous error event exists for the given identifier.
     * This will ignore the $sellerOfferId and $channelOfferId of the current event.
     * If no previous event exists, the current event is returned as is.
     * @param array<int|string, SendOfferListingFailedMessage> $failedEvents
     */
    public static function checkAndMergeWithPreviousErrors(
        int|string $identifier,
        array $failedEvents,
        SendOfferListingFailedMessage $currentEvent
    ): SendOfferListingFailedMessage {
        $previousErrorEvent = $failedEvents[$identifier] ?? null;
        if ($previousErrorEvent === null) {
            return $currentEvent;
        }

        $previousErrorEvent->getErrorList()->addItemList($currentEvent->getErrorList());

        return $previousErrorEvent;
    }

    /**
     * Merges all failed events into one event.
     * This will ignore the $sellerOfferId and $channelOfferId of the events.
     */
    public static function merge(SendOfferListingFailedMessage ...$failedEvents): SendOfferListingFailedMessage
    {
        $firstError = $failedEvents[0];
        foreach ($failedEvents as $failedEvent) {
            if ($failedEvent === $firstError) {
                continue;
            }
            $firstError->getErrorList()->addItemList($failedEvent->getErrorList());
        }

        return $firstError;
    }
}
