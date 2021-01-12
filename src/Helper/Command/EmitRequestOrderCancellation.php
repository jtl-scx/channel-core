<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2021-01-12
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitRequestOrderCancellation extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OrderCancellation';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit a Order Cancellation Event')
            ->addOption('orderCancellationRequestId', null, InputOption::VALUE_REQUIRED, 'orderCancellationRequestId')
            ->addOption('orderId', null, InputOption::VALUE_REQUIRED, 'orderId')
            ->addOption('cancelReason', null, InputOption::VALUE_REQUIRED, 'cancelReason')
            ->addOption('message', null, InputOption::VALUE_REQUIRED, 'message', "");
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOrderCancellationRequest();
    }
}
