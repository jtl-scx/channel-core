<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext
 */
class SellerReportIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerReportId = uniqid('sellerReportId', true);
        $context = new SellerReportIdContext($sellerReportId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['sellerReportId' => $sellerReportId], $context($record));
    }
}
