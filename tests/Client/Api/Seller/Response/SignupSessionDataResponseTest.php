<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Response\SignupSessionDataResponse
 */
class SignupSessionDataResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_a_jtlAccountId(): void
    {
        $sut = new SignupSessionDataResponse(12345678, 0);
        self::assertEquals(12345678, $sut->getJtlAccountId());
    }

    /**
     * @test
     */
    public function it_consider_http200_as_successful(): void
    {
        $sut = new SignupSessionDataResponse(0, 200);
        self::assertTrue($sut->isSuccessful());
    }
}
