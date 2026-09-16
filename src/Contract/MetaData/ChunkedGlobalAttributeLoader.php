<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;

/**
 * Implementations must resolve a chunk only once the previous one has been consumed.
 */
interface ChunkedGlobalAttributeLoader
{
    /**
     * @return iterable<AttributeList>
     */
    public function loadChunked(): iterable;
}
