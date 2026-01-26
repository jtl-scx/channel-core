<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Request;

use JTL\SCX\Lib\Channel\Client\Model\UpsertMarketplaceSeller;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Request\UpsertMarketplaceSellerRequest
 */
class UpsertMarketplaceSellerRequestTest extends TestCase
{
    private const JTL_ACCOUNT_ID = 12345;
    private const SELLER_ID = 'seller-456';
    private const COMPANY_NAME = 'Acme GmbH';

    private UpsertMarketplaceSellerRequest $request;

    protected function setUp(): void
    {
        $model = new UpsertMarketplaceSeller([
            'sellerId' => self::SELLER_ID,
            'isActive' => true,
            'companyName' => self::COMPANY_NAME,
        ]);

        $this->request = new UpsertMarketplaceSellerRequest(self::JTL_ACCOUNT_ID, $model);
    }

    public function testGetUrlReturnsExpectedEndpoint(): void
    {
        self::assertSame('/v1/channel/seller/{jtlAccountId}', $this->request->getUrl());
    }

    public function testGetHttpMethodReturnsPost(): void
    {
        self::assertSame('POST', $this->request->getHttpMethod());
    }

    public function testGetParamsIncludesAccountId(): void
    {
        self::assertSame(['jtlAccountId' => self::JTL_ACCOUNT_ID], $this->request->getParams());
    }

    public function testGetUpsertMarketplaceSellerModelReturnsSameInstance(): void
    {
        $model = $this->request->getUpsertMarketplaceSellerModel();

        self::assertInstanceOf(UpsertMarketplaceSeller::class, $model);
        self::assertSame(self::SELLER_ID, $model->getSellerId());
        self::assertTrue($model->getIsActive());
        self::assertSame(self::COMPANY_NAME, $model->getCompanyName());
    }

    public function testGetBodyReturnsSerializedModel(): void
    {
        $modelString = (string)$this->request->getUpsertMarketplaceSellerModel();

        self::assertSame($modelString, $this->request->getBody());
    }

    public function testMakeCreatesRequestWithDefaults(): void
    {
        $request = UpsertMarketplaceSellerRequest::make(self::JTL_ACCOUNT_ID, self::SELLER_ID);
        $model = $request->getUpsertMarketplaceSellerModel();

        self::assertSame(self::JTL_ACCOUNT_ID, $request->getParams()['jtlAccountId']);
        self::assertSame(self::SELLER_ID, $model->getSellerId());
        self::assertTrue($model->getIsActive());
        self::assertSame('', $model->getCompanyName());
    }
}
