<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Log\Context\SellerReportIdContext::class)]
class SellerReportIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $sellerReportId = uniqid('sellerReportId', true);
        $context = new SellerReportIdContext($sellerReportId);

        $record = ['foo' => 'bar'];
        self::assertSame(
            $record + ['extra' => ['sellerReportId' => $sellerReportId, 'label' => ['report', 'seller']]],
            $context($record)
        );
    }
}
