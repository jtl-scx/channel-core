<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Seller\Response\UpdateSessionResponse::class)]
class UpdateSessionResponseTest extends TestCase
{
    #[Test]
    public function it_can_provide_a_sellerId(): void
    {
        $sut = new UpdateSessionResponse($sellerId = 'A_SELLER_ID', 200);
        self::assertEquals($sellerId, $sut->getSellerId());
    }
}
