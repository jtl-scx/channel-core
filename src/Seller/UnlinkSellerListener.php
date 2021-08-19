<?php


namespace JTL\SCX\Lib\Channel\Seller;

use JTL\SCX\Client\Channel\Api\Seller\Request\UnlinkSellerRequest;
use JTL\SCX\Client\Channel\Api\Seller\SellerApi;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class UnlinkSellerListener extends AbstractListener
{
    private SellerApi $sellerApi;

    public function __construct(SellerApi $sellerApi, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->sellerApi = $sellerApi;
    }

    public function unlink(UnlinkSellerMessage $message)
    {
        $reason = $message->getReason();
        $result = $this->sellerApi->unlink(new UnlinkSellerRequest(
            (string)$message->getSellerId(),
            $reason
        ));

        if ($result->isSuccessful()) {
            $reasonLog = '';
            if ($reason !== null) {
                $reasonLog = " with reason: '{$reason}'";
            }
            $this->logger->info("Unlinked seller{$reasonLog}");
        } else {
            throw new \RuntimeException("Could not unlink Seller. HTTP-Status Code: {$result->getStatusCode()}");
        }
    }
}
