<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;
use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\SellerShippingAttributeLoader;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\ShippingAttribute\SellerShippingAttributeUpdateRequestListener
 */
class SellerShippingAttributeUpdateRequestListenerTest extends TestCase
{
    private SellerShippingAttributeUpdateRequestListener $sut;
    private SellerShippingAttributeLoader|MockObject $loader;
    private SellerShippingAttributeUpdater|MockObject $updater;

    protected function setUp(): void
    {
        $this->sut = new SellerShippingAttributeUpdateRequestListener(
            shippingAttributeLoader: $this->loader = $this->createMock(SellerShippingAttributeLoader::class),
            shippingAttributeUpdater: $this->updater = $this->createMock(SellerShippingAttributeUpdater::class),
            logger: $this->createStub(ScxLogger::class)
        );
    }

    /**
     * @test
     */
    public function it_sends_shipping_attributes_to_SCX(): void
    {
        $event = $this->createEvent('any_seller_id');
        $attributes = [new ChannelSpecificShippingAttribute(['attributeId' => 'returnAddressCarrierId'])];

        $this->loader->expects(self::once())
            ->method('fetchAll')
            ->with('any_seller_id')
            ->willReturn($attributes);

        $this->updater->expects(self::once())
            ->method('update')
            ->with('any_seller_id', $attributes);

        $this->sut->processShippingAttributes($event);
    }

    /**
     * @test
     */
    public function it_does_not_send_update_when_attribute_list_is_empty(): void
    {
        $event = $this->createEvent('any_seller_id');

        $this->loader->expects(self::once())
            ->method('fetchAll')
            ->with('any_seller_id')
            ->willReturn([]);

        $this->updater->expects(self::never())->method('update');

        $this->sut->processShippingAttributes($event);
    }

    private function createEvent(string $sellerId): AttributesUpdateRequestEvent
    {
        return new AttributesUpdateRequestEvent(
            id: 'any_id',
            clientVersion: 'any_client_version',
            createdAt: new \DateTimeImmutable(),
            event: new SellerEventSellerAttributesUpdateRequest(['sellerId' => $sellerId])
        );
    }
}
