<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Seller\Response\UpdateSessionResponse
 */
class UpdateSessionResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_provide_a_sellerId(): void
    {
        $sut = new UpdateSessionResponse($sellerId = 'A_SELLER_ID', 200);
        self::assertEquals($sellerId, $sut->getSellerId());
    }
}
