<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\ChannelApi\Merger;

use JTL\SCX\Lib\Channel\ChannelApi\SendOfferListingFailedMessage;
use JTL\SCX\Lib\Channel\Seller\ChannelSellerId;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\ChannelApi\Merger\SendOfferListingFailedMerger
 */
class SendOfferListingFailedMergerTest extends TestCase
{
    public function test_can_check_and_merge_errors(): void
    {
        $sellerId = new ChannelSellerId('seller');
        $msg1 = new SendOfferListingFailedMessage($sellerId, 1, 'CODE1', 'Error 1');
        $msg2 = new SendOfferListingFailedMessage($sellerId, 2, 'CODE2', 'Error 2');
        $msg3 = new SendOfferListingFailedMessage($sellerId, 3, 'CODE3', 'Error 3');

        $eventList = [$msg1, $msg2];

        $eventList[0] = SendOfferListingFailedMerger::checkAndMergeWithPreviousErrors(0, $eventList, $msg3);

        $this->assertCount(2, $eventList);
        $this->assertEquals('CODE1', $eventList[0]->getErrorList()[0]->getCode());
        $this->assertEquals('CODE3', $eventList[0]->getErrorList()[1]->getCode());
        $this->assertCount(2, $eventList[0]->getErrorList());
        $this->assertCount(1, $eventList[1]->getErrorList());
    }

    public function test_can_merge_errors(): void
    {
        $sellerId = new ChannelSellerId('seller');
        $msg1 = new SendOfferListingFailedMessage($sellerId, 1, 'CODE1', 'Error 1');
        $msg2 = new SendOfferListingFailedMessage($sellerId, 2, 'CODE2', 'Error 2');
        $msg3 = new SendOfferListingFailedMessage($sellerId, 3, 'CODE3', 'Error 3');

        $eventList = [$msg1, $msg2, $msg3];

        $mergedError = SendOfferListingFailedMerger::merge($eventList);

        $this->assertCount(3, $mergedError->getErrorList());
        $this->assertEquals('CODE1', $mergedError->getErrorList()[0]->getCode());
        $this->assertEquals('CODE2', $mergedError->getErrorList()[1]->getCode());
        $this->assertEquals('CODE3', $mergedError->getErrorList()[2]->getCode());
    }
}
