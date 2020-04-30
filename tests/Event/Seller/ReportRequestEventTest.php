<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventReportRequest;
use PHPUnit\Framework\TestCase;
/**
 * Class ReportRequestEventTest
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\ReportRequestEvent
 */
class ReportRequestEventTest extends TestCase
{
    public function testCanGetEvent()
    {
        $apiEventModel = $this->createStub(SellerEventReportRequest::class);
        $event = new ReportRequestEvent('id', new \DateTimeImmutable(), $apiEventModel);
        $this->assertSame($apiEventModel, $event->getEvent());
    }
}
