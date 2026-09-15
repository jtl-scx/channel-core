<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/05
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Client\Api\Attribute\AttributesApi;
use JTL\SCX\Lib\Channel\Client\Api\Attribute\Request\CreateGlobalAttributesRequest;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList as ClientAttributeList;

class GlobalAttributeSender
{
    /**
     * Upper bound of attributes packed into a single request.
     *
     * A channel can carry a single attribute with a very large enum value list (a marketplace
     * brand list, for example). Packing every attribute into one request means the domain
     * models, the mapped client models and the serialised JSON body all exist in memory at the
     * same time, which is enough to get the process killed. The SCX-API upserts each attribute
     * individually, so spreading them over several requests is equivalent and bounds the peak.
     */
    public const DEFAULT_CHUNK_SIZE = 25;

    private AttributeMapper $attributeMapper;
    private AttributesApi $api;
    private int $chunkSize;

    public function __construct(
        AttributeMapper $attributeMapper,
        AttributesApi $api,
        int $chunkSize = self::DEFAULT_CHUNK_SIZE
    ) {
        $this->attributeMapper = $attributeMapper;
        $this->api = $api;
        $this->chunkSize = $chunkSize;
    }

    public function send(AttributeList $globalAttributeList): void
    {
        foreach ($this->chunk($globalAttributeList) as $chunk) {
            $attributeList = new ClientAttributeList();
            $attributeList->setAttributeList($this->attributeMapper->map($chunk));
            $request = new CreateGlobalAttributesRequest($attributeList);
            $this->api->createGlobalAttributes($request);
        }
    }

    /**
     * @return array<AttributeList>
     */
    private function chunk(AttributeList $globalAttributeList): array
    {
        // An empty list still results in one request, as it did before chunking was introduced.
        if ($globalAttributeList->count() === 0) {
            return [$globalAttributeList];
        }

        return $globalAttributeList->chunk($this->chunkSize);
    }
}
