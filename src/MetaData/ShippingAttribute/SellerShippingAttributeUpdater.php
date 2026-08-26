<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\PutSellerShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\ShippingRulesApi;
use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;
use JTL\SCX\Lib\Channel\Client\Model\SellerShippingRules;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class SellerShippingAttributeUpdater
{
    public function __construct(private readonly ShippingRulesApi $client)
    {
    }

    /**
     * @param ChannelSpecificShippingAttribute[] $attributeList
     * @throws UnexpectedStatusException
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function update(string $sellerId, array $attributeList): void
    {
        $sellerShippingRules = new SellerShippingRules([
            'channelSpecificAttributeList' => array_values($attributeList),
        ]);
        $request = new PutSellerShippingRulesRequest($sellerId, $sellerShippingRules);
        $response = $this->client->putSellerShippingRules($request);

        if (!$response->isSuccessful()) {
            throw new UnexpectedStatusException(
                "Could not update seller shipping attributes. Request returned status code {$response->getStatusCode()}"
            );
        }
    }
}
