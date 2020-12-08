<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\ChannelApi;

use JTL\Generic\GenericCollection;

/**
 * @method ListingFailedError offsetGet($offset)
 */
class ListingFailedErrorList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(ListingFailedError::class);
    }
}
