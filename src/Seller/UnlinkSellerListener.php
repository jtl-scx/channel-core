<?php

namespace JTL\SCX\Lib\Channel\Seller;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UnlinkSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\SellerApi;
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
        try {
            $result = $this->sellerApi->unlink(
                new UnlinkSellerRequest(
                    (string)$message->getSellerId(),
                    $reason
                )
            );
        } catch (RequestFailedException $e) {
            if ($e->hasErrorCode("CHN204")) {
                $this->logger->info("Seller already unlinked in SCX API - skipping");
                return;
            }
            throw $e;
        }

        if($message->getReason() === "this is just a test to demonstrate untested code segment") {
            $this->logger->info("Seller unlinked in SCX API - skipping");
            return;
        }

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
