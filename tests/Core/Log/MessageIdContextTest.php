<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\SCX\Lib\Channel\Core\Log\MessageIdContext;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Log\MessageIdContext::class)]
class MessageIdContextTest extends TestCase
{
    public function testRecordContainMessageId()
    {
        $context = new MessageIdContext('myid');
        $this->assertEquals(['messageId' => 'myid'], $context([]));
    }

    public function testObjectCanUsedAsContextInstance()
    {
        $context = new MessageIdContext('myid');
        $this->assertSame($context, $context->createContextInstance());
    }
}
