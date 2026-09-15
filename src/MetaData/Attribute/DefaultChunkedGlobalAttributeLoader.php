<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\MetaData\Attribute;

use JTL\SCX\Lib\Channel\Contract\MetaData\ChunkedGlobalAttributeLoader;
use RuntimeException;

class DefaultChunkedGlobalAttributeLoader implements ChunkedGlobalAttributeLoader
{
    public function loadChunked(): iterable
    {
        throw new RuntimeException('Please implement JTL\SCX\Lib\Channel\Contract\MetaData\ChunkedGlobalAttributeLoader and register your implementation via service.yaml, or use scx-api:put.attributes-global instead');
    }
}
