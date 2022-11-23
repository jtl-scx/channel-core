<?php
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 11/11/22
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

enum ContextLabel: string
{
    case order = 'order';
    case offer = 'offer';
    case cancellation = 'cancellation';
    case channel = 'channel';
    case refund = 'refund';
    case seller = 'seller';
    case report = 'report';
}
