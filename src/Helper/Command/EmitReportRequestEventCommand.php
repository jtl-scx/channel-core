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

class EmitReportRequestEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.ReportRequestEvent';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit ReportRequestEvent for Testing')
            ->addOption('reportType', null, InputOption::VALUE_REQUIRED, 'reportType', null)
            ->addOption('reportId', null, InputOption::VALUE_REQUIRED, 'reportId', null)
            ->addOption('startDate', null, InputOption::VALUE_REQUIRED, 'startDate', null)
            ->addOption('endDate', null, InputOption::VALUE_REQUIRED, 'endDate', null);
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerReportRequest();
    }
}
