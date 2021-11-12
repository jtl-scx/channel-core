<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/9/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use JTL\SCX\Lib\Channel\Client\Model\OfferListingFailed;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingFailedList;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingAsFailedRequest
 */
class MarkListingAsFailedRequestTest extends TestCase
{
    public function testCanInitiateWithOfferListModel()
    {
        $model = $this->createStub(OfferListingFailedList::class);
        $model->method('__toString')->willReturn('this_is_json');

        $request = new MarkListingAsFailedRequest($model);
        $this->assertEquals('this_is_json', $request->getBody());
    }

    public function testCanReadOfferListModel()
    {
        $request = new MarkListingAsFailedRequest();
        $this->assertJson($request->getBody());
    }

    public function testCanAddOffer()
    {
        $request = new MarkListingAsFailedRequest();

        $request->addOffer(new OfferListingFailed(['sellerId' => 'failedOffer1', 'offerId' => 1, 'errorList' => [], 'failedAt' => $this->createStub(\DateTime::class)]));
        $request->addOffer(new OfferListingFailed(['sellerId' => 'failedOffer2', 'offerId' => 2, 'errorList' => [], 'failedAt' => $this->createStub(\DateTime::class)]));
        $request->addOffer(new OfferListingFailed(['sellerId' => 'failedOffer3', 'offerId' => 3, 'errorList' => [], 'failedAt' => $this->createStub(\DateTime::class)]));

        $body = $request->getBody();

        $this->assertJson($request->getBody());
        $this->assertStringContainsString('failedOffer1', $body);
        $this->assertStringContainsString('failedOffer2', $body);
        $this->assertStringContainsString('failedOffer3', $body);
    }

    public function testHttpMethodIsCorrect()
    {
        $request = new MarkListingAsFailedRequest();
        $this->assertEquals(ScxApiRequest::HTTP_METHOD_POST, $request->getHttpMethod());
    }

    public function testEndpointUrlIsCorrect()
    {
        $request = new MarkListingAsFailedRequest();
        $this->assertEquals('/v1/channel/offer/listing-failed', $request->getUrl());
    }
}
