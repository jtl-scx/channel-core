<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Contract\MetaData;

use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;

/**
 * Loads global attributes in chunks instead of building the complete list up front.
 *
 * A channel whose attribute set is small enough to fit in memory can keep implementing
 * GlobalAttributeLoader alone. Implement this interface additionally when resolving all
 * attributes at once is too expensive - for example when a single attribute carries a value
 * list of several thousand entries - and use scx-api:put.attributes-global-chunked instead of
 * scx-api:put.attributes-global.
 *
 * Implementations are expected to be lazy: a chunk should only be resolved once the previous one
 * has been consumed, so that the caller can release it before the next one is built.
 */
interface ChunkedGlobalAttributeLoader
{
    /**
     * @return iterable<AttributeList>
     */
    public function loadChunked(): iterable;
}
