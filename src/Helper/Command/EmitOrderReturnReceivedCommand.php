<?php

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'helper:emit.OrderReturnReceived')]
class EmitOrderReturnReceivedCommand extends AbstractEmitEventCommand
{
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
