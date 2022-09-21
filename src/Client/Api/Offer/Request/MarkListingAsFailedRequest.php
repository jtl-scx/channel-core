<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/8/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingFailed;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingFailedList;
use JTL\SCX\Client\Request\ScxApiRequest;

class MarkListingAsFailedRequest extends AbstractScxApiRequest
{
    private OfferListingFailedList $offerList;

    public function __construct(OfferListingFailedList $offerList = null)
    {
        $this->offerList = $offerList ?? new OfferListingFailedList(['offerList' => []]);
    }

    public function addOffer(OfferListingFailed $offer): void
    {
        $newOfferList = $this->offerList->getOfferList();
        $newOfferList[] = $offer;
        $this->offerList->setOfferList($newOfferList);
    }

    public function getBody(): ?string
    {
        return (string)$this->offerList;
    }

    public function getUrl(): string
    {
        return '/v1/channel/offer/listing-failed';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }
}
