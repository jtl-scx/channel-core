<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-22
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Core\Log\Context\CancellationRequestIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\CancellationRequestIdContext
 */
class CancellationRequestIdContextTest extends TestCase
{
    public function testItWillAddOrderCancellationRequestIdToRecord(): void
    {
        $id = uniqid('id', true);
        $context = new CancellationRequestIdContext($id);

        $records = ['foo' => 'bar'];
        $records = $context($records);

        self::assertIsArray($records);
        self::assertArrayHasKey('orderCancellationRequestId', $records);
        self::assertSame($id, $records['orderCancellationRequestId']);
    }

    public function testCanCreateContextInstance()
    {
        $context = new CancellationRequestIdContext(uniqid());
        self::assertIsCallable($context->createContextInstance());
    }
}
