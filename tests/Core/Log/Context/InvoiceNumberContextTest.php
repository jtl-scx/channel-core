<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\Context\InvoiceNumberContext
 */
class InvoiceNumberContextTest extends TestCase
{

    public function testCanCreateContext(): void
    {
        $invoiceNumber = uniqid('invoiceNumber', true);
        $context = new InvoiceNumberContext($invoiceNumber);
        $callable = $context->createContextInstance();
        $record = $callable([]);
        self::assertSame($invoiceNumber, $record['extra']['invoiceNumber']);
        self::assertSame(['invoice'], $record['extra']['label']);
    }
}
