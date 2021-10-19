<?php

namespace JTL\SCX\Lib\Channel\Order\Refunds;

use JTL\SCX\Client\Channel\Api\Order\OrderApi;
use JTL\SCX\Client\Channel\Api\Order\Request\ReturnOrderRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class SendAnnouncedReturnListener extends AbstractListener
{
    private OrderApi $channelApi;

    public function __construct(OrderApi $channelApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->channelApi = $channelApi;
    }

    public function sendToChannelApi(SendAnnouncedReturnMessage $announcedReturnMessage): void
    {
        $returnAnnouncement = $announcedReturnMessage->getReturnAnnouncement();
        $this->channelApi->sendOrderReturn(new ReturnOrderRequest($returnAnnouncement));
        $this->logger->info(
            "Sent Announced Order Returns to Channel-Api",
            ["channelReturnId" => $returnAnnouncement->getChannelReturnId()]
        );
    }
}