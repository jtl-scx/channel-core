<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-29
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\RefundIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\RefundIdContext
 */
class RefundIdContextTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $refundId = uniqid('refundId', true);
        $context = new RefundIdContext($refundId);

        $record = ['foo' => 'bar'];
        self::assertSame($record + ['extra' => ['refundId' => $refundId, 'label' => ['refund']]], $context($record));
    }
}
