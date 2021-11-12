<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-24
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Input\InputOption;

class EmitSellerOrderInvoiceCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OrderInvoice';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit a Order Invoice Event')
            ->addOption('documentId', null, InputOption::VALUE_REQUIRED, 'documentId')
            ->addOption('orderId', null, InputOption::VALUE_REQUIRED, 'orderId')
            ->addOption('invoiceNumber', null, InputOption::VALUE_REQUIRED, 'invoiceNumber')
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'type');
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerEventOrderInvoice();
    }
}
