<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Attribute\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\AttributeList;

class CreateGlobalAttributesRequest extends AbstractScxApiRequest
{
    private AttributeList $attributeList;

    public function __construct(AttributeList $attributeList)
    {
        $this->attributeList = $attributeList;
    }

    public function getBody(): ?string
    {
        return (string)$this->attributeList;
    }

    public function getUrl(): string
    {
        return '/v1/channel/attribute/global';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_METHOD_PUT;
    }
}
