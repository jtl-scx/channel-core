<?php


namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitOrderReturnReceivedCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OrderReturnReceived';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit Return Received Event for Testing')
            ->addOption('orderId', null, InputOption::VALUE_REQUIRED, 'orderId', null);
    }


    protected function getEventType(): EventType
    {
        return EventType::SellerOrderReturnReceived();
    }
}
