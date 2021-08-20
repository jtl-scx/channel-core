<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */

namespace JTL\SCX\Lib\Channel\Core\Log;

use JTL\SCX\Lib\Channel\Core\Log\MessageIdContext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Log\MessageIdContext
 */
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
