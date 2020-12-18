<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/25/20
 */
namespace JTL\SCX\Lib\Channel\Notification;

use JTL\SCX\Client\Channel\Model\ChannelNotificationReference;
use PHPUnit\Framework\TestCase;

/**
 * Class NotificationReferenceTest
 * @covers \JTL\SCX\Lib\Channel\Notification\NotificationReference
 */
class NotificationReferenceTest extends TestCase
{
    public function testCanCreateOfferReference()
    {
        $ref = NotificationReference::offer('123');
        $this->assertEquals(ChannelNotificationReference::TYPE_OFFER, $ref->getType());
    }

    public function testCanCreateOrderItemIdReference()
    {
        $ref = NotificationReference::orderItemId('123');
        $this->assertEquals(ChannelNotificationReference::TYPE_ORDERITEMID, $ref->getType());
    }

    public function testCanCreateChannelOfferIdReference()
    {
        $ref = NotificationReference::channelOffer('123');
        $this->assertEquals(ChannelNotificationReference::TYPE_CHANNELOFFER, $ref->getType());
    }

    public function testCanGetType()
    {
        $type = uniqid('ref');
        $ref = new NotificationReference($type, '123');
        $this->assertEquals($type, $ref->getType());
    }

    public function testCanGetId()
    {
        $id = uniqid('id');
        $ref = new NotificationReference('foo', $id);
        $this->assertEquals($id, $ref->getId());
    }
}
