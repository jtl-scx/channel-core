<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\MetaData\ShippingAttribute;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Api\Meta\Request\PutSellerShippingRulesRequest;
use JTL\SCX\Lib\Channel\Client\Api\Meta\ShippingRulesApi;
use JTL\SCX\Lib\Channel\Client\Model\ChannelSpecificShippingAttribute;
use JTL\SCX\Lib\Channel\Client\Model\SellerShippingRules;
use JTL\SCX\Lib\Channel\Core\Exception\UnexpectedStatusException;

class SellerShippingAttributeUpdater
{
    /**
     * SCX caps the channel specific shipping attributes at 8 entries per seller
     * (PUT /v1/channel/shipping-rules/{sellerId}, error code CHN504).
     */
    public const MAX_ATTRIBUTES = 8;

    public function __construct(private readonly ShippingRulesApi $client)
    {
    }

    /**
     * @param ChannelSpecificShippingAttribute[] $attributeList
     * @throws InvalidArgumentException when the list exceeds the SCX limit or an attribute misses required fields
     * @throws UnexpectedStatusException
     * @throws GuzzleException
     * @throws RequestFailedException
     */
    public function update(string $sellerId, array $attributeList): void
    {
        $attributeList = array_values($attributeList);
        $this->guardAgainstInvalidAttributes($attributeList);

        $sellerShippingRules = new SellerShippingRules([
            'channelSpecificAttributeList' => $attributeList,
        ]);
        $request = new PutSellerShippingRulesRequest($sellerId, $sellerShippingRules);
        $response = $this->client->putSellerShippingRules($request);

        if (!$response->isSuccessful()) {
            throw new UnexpectedStatusException(
                "Could not update seller shipping attributes. Request returned status code {$response->getStatusCode()}"
            );
        }
    }

    /**
     * Validates the list before it is serialized into a request. Without this a missing required field
     * (displayName, type, level) would only surface as a TypeError deep inside ObjectSerializer when the
     * non-nullable getters are called, which is hard to trace. Failing here keeps errors deterministic.
     *
     * @param ChannelSpecificShippingAttribute[] $attributeList
     * @throws InvalidArgumentException
     */
    private function guardAgainstInvalidAttributes(array $attributeList): void
    {
        $count = count($attributeList);
        if ($count > self::MAX_ATTRIBUTES) {
            throw new InvalidArgumentException(
                "Too many channel specific shipping attributes: {$count} given, but SCX accepts at most "
                . self::MAX_ATTRIBUTES . ' per seller.'
            );
        }

        foreach ($attributeList as $index => $attribute) {
            $invalidProperties = $attribute->listInvalidProperties();
            if ($invalidProperties !== []) {
                throw new InvalidArgumentException(
                    "Invalid channel specific shipping attribute at index {$index}: "
                    . implode(', ', $invalidProperties)
                );
            }
        }
    }
}
