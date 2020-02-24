<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace Event;

use DateTimeImmutable;
use Exception;
use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\SellerEventOfferEnd;
use JTL\SCX\Client\Channel\Model\SellerEventOfferNew;
use JTL\SCX\Client\Channel\Model\SellerEventOfferUpdate;
use JTL\SCX\Client\Channel\Model\SellerEventOrderCancelled;
use JTL\SCX\Client\Channel\Model\SellerEventOrderConfirmed;
use JTL\SCX\Client\Channel\Model\SellerEventOrderPayment;
use JTL\SCX\Client\Channel\Model\SellerEventOrderShipping;
use JTL\SCX\Client\Channel\Model\SellerEventTest;
use JTL\SCX\Client\Channel\Model\SystemEventNotification;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use JTL\SCX\Lib\Channel\Event\Seller\OfferEndEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferNewEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OfferUpdateEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderCancelledEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderConfirmedEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderPaymentEvent;
use JTL\SCX\Lib\Channel\Event\Seller\OrderShippingEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemNotificationEvent;
use JTL\SCX\Lib\Channel\Event\Seller\SystemTestEvent;
use PHPUnit\Framework\TestCase;

/**
 * Class EventFactoryTest
 * @covers \JTL\SCX\Lib\Channel\Event\EventFactory
 */
class EventFactoryTest extends TestCase
{
    public function eventTestCasesProvider(): array
    {
        return [
            [SystemNotificationEvent::class, SystemEventNotification::class, EventType::SystemNotification()],
            [SystemTestEvent::class, SellerEventTest::class, EventType::SellerEventTest()],
            [OrderShippingEvent::class, SellerEventOrderShipping::class, EventType::SellerOrderShipping()],
            [OrderPaymentEvent::class, SellerEventOrderPayment::class, EventType::SellerOrderPayment()],
            [OrderConfirmedEvent::class, SellerEventOrderConfirmed::class, EventType::SellerOrderConfirmed()],
            [OrderCancelledEvent::class, SellerEventOrderCancelled::class, EventType::SellerOrderCancelled()],
            [OfferNewEvent::class, SellerEventOfferNew::class, EventType::SellerOfferNew()],
            [OfferUpdateEvent::class, SellerEventOfferUpdate::class, EventType::SellerOfferUpdate()],
            [OfferEndEvent::class, SellerEventOfferEnd::class, EventType::SellerOfferEnd()]
        ];
    }

    /**
     * @dataProvider eventTestCasesProvider
     * @param $expectation
     * @param $eventModel
     * @param $eventTypeString
     * @throws Exception
     */
    public function testCanCreateEventFromContainer($expectation, $eventModel, $eventTypeString)
    {
        $containerMock = $this->createMock(EventContainer::class);
        $containerMock->expects($this->atLeastOnce())->method('getType')
            ->willReturn($eventTypeString);
        $containerMock->expects($this->atLeastOnce())->method('getEvent')
            ->willReturn($this->createStub($eventModel));

        $containerMock->expects($this->any())->method('getId')->willReturn(uniqid("id"));
        $containerMock->expects($this->any())->method('getCreatedAt')->willReturn(new DateTimeImmutable());

        $factory = new EventFactory();
        $this->assertInstanceOf($expectation, $factory->createFromEventContainer($containerMock));
    }

    public function testWillReturnNullOnUnknownEvent()
    {
        $containerMock = $this->createMock(EventContainer::class);
        $containerMock->expects($this->atLeastOnce())->method('getType')
            ->willReturn(new EventType('Foo.Mag.Bar'));
        $containerMock->expects($this->never())->method('getEvent');

        $factory = new EventFactory();
        $this->assertNull($factory->createFromEventContainer($containerMock));
    }
}
