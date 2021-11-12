<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/9/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Request;

use DateTime;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingInProgress;
use JTL\SCX\Lib\Channel\Client\Model\OfferListingInProgressList;
use JTL\SCX\Client\Request\ScxApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Offer\Request\MarkListingInProgressRequest
 */
class MarkListingInProgressRequestTest extends TestCase
{
    public function testCanInitiateWithOfferListModel()
    {
        $model = $this->createStub(OfferListingInProgressList::class);
        $model->method('__toString')->willReturn('in progress');
        $request = new MarkListingInProgressRequest($model);
        $this->assertEquals('in progress', $request->getBody());
    }

    public function testCanReadBody()
    {
        $request = new MarkListingInProgressRequest();
        $this->assertJson($request->getBody());
    }

    public function testCanAddOffer()
    {
        $request = new MarkListingInProgressRequest();

        $request->addOffer(new OfferListingInProgress(['sellerId' => 'offerId1', 'offerId' => 1, 'startedAt' => $this->createStub(DateTime::class)]));
        $request->addOffer(new OfferListingInProgress(['sellerId' => 'offerId2', 'offerId' => 2, 'startedAt' => $this->createStub(DateTime::class)]));
        $request->addOffer(new OfferListingInProgress(['sellerId' => 'offerId3', 'offerId' => 3, 'startedAt' => $this->createStub(DateTime::class)]));

        $body = $request->getBody();

        $this->assertJson($request->getBody());
        $this->assertStringContainsString('offerId1', $body);
        $this->assertStringContainsString('offerId2', $body);
        $this->assertStringContainsString('offerId3', $body);
    }

    public function testHttpMethodIsCorrect()
    {
        $request = new MarkListingInProgressRequest();
        $this->assertEquals(ScxApiRequest::HTTP_METHOD_POST, $request->getHttpMethod());
    }

    public function testEndpointUrlIsCorrect()
    {
        $request = new MarkListingInProgressRequest();
        $this->assertEquals('/v1/channel/offer/in-progress', $request->getUrl());
    }
}
