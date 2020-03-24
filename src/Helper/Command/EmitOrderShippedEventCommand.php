<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-24
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitOrderShippedEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OrderShippedEvent';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit OrderShippedEvent for Testing')
            ->addOption('orderId', null, InputOption::VALUE_OPTIONAL, 'orderId', null)
            ->addOption('shippingComplete', null, InputOption::VALUE_OPTIONAL, 'Is ShippingComplete?', null)
            ->addOption('shippedAt', null, InputOption::VALUE_OPTIONAL, 'Shipping Date', null);
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOrderShipping();
    }
}
