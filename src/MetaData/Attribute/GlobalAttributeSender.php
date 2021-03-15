<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2021/03/05
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Client\Channel\Api\Attribute\AttributesApi;
use JTL\SCX\Client\Channel\Api\Attribute\Request\CreateGlobalAttributesRequest;
use JTL\SCX\Client\Channel\Model\AttributeList as ClientAttributeList;

class GlobalAttributeSender
{
    private AttributeMapper $attributeMapper;
    private AttributesApi $api;

    public function __construct(AttributeMapper $attributeMapper, AttributesApi $api)
    {
        $this->attributeMapper = $attributeMapper;
        $this->api = $api;
    }

    public function send(AttributeList $globalAttributeList): void
    {
        $attributeList = new ClientAttributeList();
        $attributeList->setAttributeList($this->attributeMapper->map($globalAttributeList));
        $request = new CreateGlobalAttributesRequest($attributeList);
        $this->api->createGlobalAttributes($request);
    }
}
