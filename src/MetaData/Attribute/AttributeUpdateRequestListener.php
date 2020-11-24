<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/20
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;
use JTL\SCX\Lib\Channel\Core\Message\AbstractListener;
use JTL\SCX\Lib\Channel\Event\Seller\AttributesUpdateRequestEvent;

class AttributeUpdateRequestListener extends AbstractListener
{
    private SellerAttributeLoader $attributeLoader;
    private SellerAttributeUpdater $attributeUpdater;

    public function __construct(
        SellerAttributeLoader $attributeLoader,
        SellerAttributeUpdater $attributeUpdater,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->attributeLoader = $attributeLoader;
        $this->attributeUpdater = $attributeUpdater;
    }

    /**
     * @param AttributesUpdateRequestEvent $event
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     * @throws UnexpectedStatusException
     */
    public function processAttributes(AttributesUpdateRequestEvent $event): void
    {
        $sellerId = $event->getEvent()->getSellerId();
        $attributeList = $this->attributeLoader->fetchAll($sellerId);
        $this->attributeUpdater->update($sellerId, $attributeList);
        $this->logger->info("Attributes updated successfully for seller ID: {$sellerId}");
    }
}
