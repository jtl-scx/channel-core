<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/22/21
 */

namespace MetaData\Attribute;

use JTL\SCX\Client\Channel\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeUpdateRequestListener;
use JTL\SCX\Lib\Channel\MetaData\Attribute\SellerAttributeUpdater;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeUpdateRequestListener
 */
class AttributeUpdateRequestListenerTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_fetch_attributes_and_send_them_to_Channel_Api(): void
    {
        $sellerId = 'A_SELLER';
        $attributeList = new AttributeList();

        $loader = $this->createMock(SellerAttributeLoader::class);
        $loader->expects($this->once())->method('fetchAll')->with($sellerId)->willReturn($attributeList);

        $updater = $this->createMock(SellerAttributeUpdater::class);
        $updater->expects($this->once())->method('update')->with($sellerId, $attributeList);

        $sut = new AttributeUpdateRequestListener(
            $loader,
            $updater,
            $this->createStub(ScxLogger::class)
        );

        $event = $this->createTestEvent($sellerId);
        $sut->processAttributes($event);
    }

    /**
     * @param string $sellerId
     * @return AttributesUpdateRequestEvent|Stub
     */
    private function createTestEvent(string $sellerId)
    {
        $updateRequest = new SellerEventSellerAttributesUpdateRequest(['sellerId' => $sellerId]);
        $event = $this->createStub(AttributesUpdateRequestEvent::class);
        $event->method('getEvent')->willReturn($updateRequest);
        return $event;
    }
}
