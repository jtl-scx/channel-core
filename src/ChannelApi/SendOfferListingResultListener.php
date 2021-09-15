<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Offer\OfferApi;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingAsFailedRequest;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingInProgressRequest;
use JTL\SCX\Client\Channel\Api\Offer\Request\MarkListingSuccessfulRequest;
use JTL\SCX\Client\Channel\Model\OfferListingFailed;
use JTL\SCX\Client\Channel\Model\OfferListingFailedError;
use JTL\SCX\Client\Channel\Model\OfferListingInProgress;
use JTL\SCX\Client\Channel\Model\OfferListingSuccessful;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;

class SendOfferListingResultListener extends AbstractListener
{
    private OfferApi $offerApi;

    public function __construct(OfferApi $api, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->offerApi = $api;
    }

    /**
     * @param SendOfferListingInProgressMessage $event
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function sendInProgress(SendOfferListingInProgressMessage $event): void
    {
        try {
            $offer = new OfferListingInProgress();
            $offer->setSellerId((string)$event->getSellerId());
            $offer->setOfferId($event->getSellerOfferId());
            $offer->setStartedAt($event->getStartedAt());

            $request = new MarkListingInProgressRequest();
            $request->addOffer($offer);

            $this->logger->info('Mark Offer Listing in progress');
            $this->offerApi->markInProgress($request);
        } catch (RequestFailedException $e) {
            $this->handleError($e);
        }
    }

    /**
     * @param SendOfferListingFailedMessage $event
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function sendInFailed(SendOfferListingFailedMessage $event): void
    {
        try {
            $offer = new OfferListingFailed();
            $offer->setSellerId((string)$event->getSellerId());
            $offer->setOfferId($event->getSellerOfferId());
            $offer->setFailedAt($event->getFailedAt());

            $errorList = [];
            $logMessage = "";
            foreach ($event->getErrorList() as $err) {
                $nextError = new OfferListingFailedError();
                $nextError->setCode($err->getCode());
                $nextError->setMessage($err->getMessage());
                $nextError->setLongMessage($err->getLongMessage());
                $errorList[] = $nextError;

                $logMessage = sprintf(
                    '- "%s" "%s" (Code: "%s")',
                    $err->getMessage(),
                    $err->getLongMessage(),
                    $err->getCode()
                );
            }
            $offer->setErrorList($errorList);

            $request = new MarkListingAsFailedRequest();
            $request->addOffer($offer);

            $this->offerApi->markListingFailed($request);
            $this->logger->info("Listing failed request send. Listing errors:\n\n" . $logMessage);
        } catch (RequestFailedException $e) {
            $this->handleError($e);
        }
    }

    /**
     * @param SendOfferListingSuccessfulMessage $event
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function sendSuccessful(SendOfferListingSuccessfulMessage $event): void
    {
        try {
            $offer = new OfferListingSuccessful();
            $offer->setSellerId((string)$event->getSellerId());
            $offer->setOfferId($event->getSellerOfferId());
            $offer->setListedAt($event->getListedAt());
            $offer->setListingUrl($event->getListingUrl());
            $offer->setChannelOfferId($event->getChannelOfferId());

            $request = new MarkListingSuccessfulRequest();
            $request->addOffer($offer);

            $this->logger->info('Mark Offer listing successful', ['listingUrl' => $offer->getListingUrl()]);
            $this->offerApi->markListed($request);
        } catch (RequestFailedException $e) {
            $this->handleError($e);
        }
    }

    /**
     * @param RequestFailedException $exception
     * @throws RequestFailedException
     */
    private function handleError(RequestFailedException $exception): void
    {
        $error = '';
        foreach ($exception->getErrorResponseList() as $error) {
            $error .= "[{$error->getSeverity()}} {$error->getMessage()} ({$error->getCode()})\n";
        }

        $this->logger->warning("{$exception->getMessage()}\n\n{$error}");
        throw $exception;
    }
}
