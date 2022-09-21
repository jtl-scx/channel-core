<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-12-27
 */

namespace JTL\SCX\Lib\Channel\MetaData\Price;

use JTL\Generic\GenericCollection;
use JTL\SCX\Lib\Channel\Client\Model\PriceType;

class PriceTypeList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(PriceType::class);
    }
}
