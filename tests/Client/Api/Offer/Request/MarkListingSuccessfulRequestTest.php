<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/9/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use DateTime;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingSuccessful;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingSuccessfulList;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingSuccessfulRequest
 */
class MarkListingSuccessfulRequestTest extends TestCase
{
    public function testCanInitiateWithOfferListModel()
    {
        $model = $this->createStub(OfferListingSuccessfulList::class);
        $model->method('__toString')->willReturn('juhu');
        $request = new MarkListingSuccessfulRequest($model);
        $this->assertEquals('juhu', $request->getBody());
    }

    public function testCanReadOfferListModel()
    {
        $request = new MarkListingSuccessfulRequest();
        $this->assertJson($request->getBody());
    }

    public function testCanAddOffer()
    {
        $request = new MarkListingSuccessfulRequest();

        $request->addOffer(new OfferListingSuccessful(['sellerId' => 'activeOffer1', 'offerId' => 1, 'listedAt' => $this->createStub(DateTime::class)]));
        $request->addOffer(new OfferListingSuccessful(['sellerId' => 'activeOffer2', 'offerId' => 2, 'listedAt' => $this->createStub(DateTime::class)]));
        $request->addOffer(new OfferListingSuccessful(['sellerId' => 'activeOffer3', 'offerId' => 3, 'listedAt' => $this->createStub(DateTime::class)]));

        $body = $request->getBody();

        $this->assertJson($request->getBody());
        $this->assertStringContainsString('activeOffer1', $body);
        $this->assertStringContainsString('activeOffer2', $body);
        $this->assertStringContainsString('activeOffer3', $body);
    }

    public function testHttpMethodIsCorrect()
    {
        $request = new MarkListingSuccessfulRequest();
        $this->assertEquals(ScxApiRequest::HTTP_METHOD_POST, $request->getHttpMethod());
    }

    public function testEndpointUrlIsCorrect()
    {
        $request = new MarkListingSuccessfulRequest();
        $this->assertEquals('/v1/channel/offer/listed', $request->getUrl());
    }
}
