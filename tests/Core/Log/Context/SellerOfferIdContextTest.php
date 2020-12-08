<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\SellerOfferIdContext
 */
class SellerOfferIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerOfferId = uniqid('sellerOfferId', true);
        $context = new SellerOfferIdContext($sellerOfferId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['sellerOfferId' => $sellerOfferId], $context($record));
    }
}
