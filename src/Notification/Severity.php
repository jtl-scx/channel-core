<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 3/24/20
 */

namespace JTL\SCX\Lib\Channel\Notification;

use JTL\SCX\Client\Channel\Model\Notification;
use MyCLabs\Enum\Enum;

/**
 * Class PriceTypeEnum
 * @method static Severity INFO()
 * @method static Severity WARNING()
 * @method static Severity ERROR()
 */
class Severity extends Enum
{
    public const INFO = Notification::SEVERITY_INFO;
    public const WARNING = Notification::SEVERITY_WARNING;
    public const ERROR = Notification::SEVERITY_ERROR;
}
