<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Client\Model\SellerEventSellerAttributesUpdateRequest;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeUpdateRequestListener
 */
class AttributeUpdateRequestListenerTest extends TestCase
{
    private AttributeUpdateRequestListener $sut;
    private SellerAttributeLoader|MockObject $loader;
    private SellerAttributeUpdater|MockObject $updater;

    protected function setUp(): void
    {
        $this->sut = new AttributeUpdateRequestListener(
            attributeLoader: $this->loader = $this->createMock(SellerAttributeLoader::class),
            attributeUpdater: $this->updater = $this->createMock(SellerAttributeUpdater::class),
            logger: $this->createStub(ScxLogger::class)
        );
    }

    /**
     * @test
     */
    public function it_send_updated_attributeList_to_SCX(): void
    {
        $event = new AttributesUpdateRequestEvent(
            id: 'any_id',
            clientVersion: 'any_client_version',
            createdAt: new \DateTimeImmutable(),
            event: new SellerEventSellerAttributesUpdateRequest(['sellerId' => 'any_seller_id'])
        );

        $attributes = new AttributeList();
        $attributes->add(new Attribute('any_name', 'any_value'));

        $this->loader->expects(self::once())
            ->method('fetchAll')
            ->with('any_seller_id')
            ->willReturn($attributes);

        $this->updater->expects(self::once())
            ->method('update')
            ->with('any_seller_id', $attributes);

        $this->sut->processAttributes($event);
    }


    /**
     * @test
     */
    public function it_dont_send_update_when_attributes_are_empty(): void
    {
        $event = new AttributesUpdateRequestEvent(
            id: 'any_id',
            clientVersion: 'any_client_version',
            createdAt: new \DateTimeImmutable(),
            event: new SellerEventSellerAttributesUpdateRequest(['sellerId' => 'any_seller_id'])
        );

        $emptyList = new AttributeList();
        $this->loader->expects(self::once())
            ->method('fetchAll')
            ->with('any_seller_id')
            ->willReturn($emptyList);

        $this->updater->expects(self::never())->method('update');

        $this->sut->processAttributes($event);
    }

}
