<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\SellerShippingAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;

/**
 * EA-8054: Reacts to the same seller-attribute refresh event as the product attributes and pushes the
 * channel's seller specific shipping attributes to SCX. Channels without an implementation keep the
 * DefaultSellerShippingAttributeLoader (empty list) and therefore push nothing.
 */
class SellerShippingAttributeUpdateRequestListener extends AbstractListener
{
    public function __construct(
        private readonly SellerShippingAttributeLoader $shippingAttributeLoader,
        private readonly SellerShippingAttributeUpdater $shippingAttributeUpdater,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
    }

    /**
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws UnexpectedStatusException
     */
    public function processShippingAttributes(AttributesUpdateRequestEvent $event): void
    {
        $sellerId = (string)$event->getEvent()->getSellerId();
        $attributeList = $this->shippingAttributeLoader->fetchAll($sellerId);

        if (count($attributeList) > 0) {
            $this->shippingAttributeUpdater->update($sellerId, $attributeList);
            $this->logger->info("Shipping attributes updated successfully for seller ID: {$sellerId}");
        }
    }
}
