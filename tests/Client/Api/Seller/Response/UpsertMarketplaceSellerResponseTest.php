<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Response\UpsertMarketplaceSellerResponse
 */
class UpsertMarketplaceSellerResponseTest extends TestCase
{
    private const STATUS_OK = 200;

    private UpsertMarketplaceSellerResponse $response;

    protected function setUp(): void
    {
        $this->response = new UpsertMarketplaceSellerResponse(self::STATUS_OK);
    }

    public function testGetStatusCodeReturnsConstructorValue(): void
    {
        self::assertSame(self::STATUS_OK, $this->response->getStatusCode());
    }

    public function testIsSuccessfulReturnsTrueFor2xx(): void
    {
        self::assertTrue($this->response->isSuccessful());
        self::assertTrue((new UpsertMarketplaceSellerResponse(299))->isSuccessful());
    }

    public function testIsSuccessfulReturnsFalseForNon2xx(): void
    {
        self::assertFalse((new UpsertMarketplaceSellerResponse(199))->isSuccessful());
        self::assertFalse((new UpsertMarketplaceSellerResponse(300))->isSuccessful());
    }
}
