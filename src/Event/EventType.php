<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event;


use MyCLabs\Enum\Enum;

/**
 * @method static EventType SYSTEM__NOTIFICATION()
 * @method static EventType SYSTEM__TEST()
 * @method static EventType SELLER__ORDER_SHIPPING()
 * @method static EventType SELLER__ORDER_PAYMENT()
 * @method static EventType SELLER__ORDER_CONFIRMED()
 * @method static EventType SELLER__ORDER_CANCELLED()
 * @method static EventType SELLER__OFFER_NEW()
 * @method static EventType SELLER__OFFER_END()
 */
class EventType extends Enum
{
    const SYSTEM__NOTIFICATION = "System:Notification";
    const SYSTEM__TEST = "System:Test";

    const SELLER__ORDER_SHIPPING = "Seller:Order.Shipping";
    const SELLER__ORDER_PAYMENT = "Seller:Order.Payment";
    const SELLER__ORDER_CONFIRMED = "Seller:Order.Confirmed";
    const SELLER__ORDER_CANCELLED = "Seller:Order.Cancelled";
    const SELLER__OFFER_NEW = "Seller:Offer.New";
    const SELLER__OFFER_END = "Seller:Offer.End";
}
