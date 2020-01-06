<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-02
 */

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader;
use RuntimeException;

class DefaultSellerAttributeLoader implements SellerAttributeLoader
{
    public function fetchAll(string $sellerId): AttributeList
    {
        throw new RuntimeException('Please implement JTL\SCX\Lib\Channel\Contract\MetaData\SellerAttributeLoader and register your implementation via service.yaml');
    }
}
