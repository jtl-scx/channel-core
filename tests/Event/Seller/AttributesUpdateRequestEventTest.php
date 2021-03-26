<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-03-26
 */

namespace Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent
 */
class AttributesUpdateRequestEventTest extends TestCase
{
    public function testCanReceiveEvent()
    {
        $apiEventModel = $this->createStub(SellerEventSellerAttributesUpdateRequest::class);
        $event = new AttributesUpdateRequestEvent('id', new \DateTimeImmutable(), $apiEventModel);
        self::assertSame($apiEventModel, $event->getEvent());
    }

    public function testCanBeCreatedWithSeller(): void
    {
        $sellerId = uniqid('sellerId', true);
        $event = AttributesUpdateRequestEvent::seller($sellerId);

        self::assertInstanceOf(AttributesUpdateRequestEvent::class, $event);
        self::assertInstanceOf(SellerEventSellerAttributesUpdateRequest::class, $event->getEvent());
        self::assertSame($sellerId, $event->getEvent()->getSellerId());
    }
}
