<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext
 */
class SellerOfferIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerOfferId = random_int(1, 10000);
        $context = new SellerOfferIdContext($sellerOfferId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['extra' => ['sellerOfferId' => $sellerOfferId, 'label' => ['offer']]], $context($record));
    }
}
