<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-24
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitOrderAcceptCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OrderAccept';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit OrderAccept for Testing')
            ->addOption('orderId', null, InputOption::VALUE_REQUIRED, 'offerId', null)
            ->addOption('reason', null, InputOption::VALUE_REQUIRED, 'reason when reject an order', null);
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOrderAccept();
    }
}
