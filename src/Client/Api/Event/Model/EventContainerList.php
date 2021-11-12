<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/7/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Model;

use JTL\Generic\GenericCollection;

/**
 * @method EventContainer offsetGet($offset)
 */
class EventContainerList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(EventContainer::class);
    }
}
