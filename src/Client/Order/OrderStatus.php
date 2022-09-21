<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-02-27
 */

namespace JTL\SCX\Lib\Channel\Client\Order;

use MyCLabs\Enum\Enum;

/**
 * Class OrderStatus
 * @method static OrderStatus CREATED()
 * @method static OrderStatus ACCEPTED()
 * @method static OrderStatus SHIPPED()
 * @method static OrderStatus PARTIALLY_SHIPPED()
 * @method static OrderStatus CANCELED_BY_SELLER()
 * @method static OrderStatus CANCELED_BY_BUYER()
 *
 * @psalm-immutable
 * @deprecated
 */
class OrderStatus extends Enum
{
    public const CREATED = 'CREATED';
    public const ACCEPTED = 'ACCEPTED';
    public const SHIPPED = 'SHIPPED';
    public const PARTIALLY_SHIPPED = 'PARTIALLY_SHIPPED';
    public const CANCELED_BY_SELLER = 'CANCELED_BY_SELLER';
    public const CANCELED_BY_BUYER = 'CANCELED_BY_BUYER';
}
