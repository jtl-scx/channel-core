<?php

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Client\Event\EventType;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'helper:emit.SystemNotification')]
class EmitSystemNotificationCommand extends AbstractEmitEventCommand
{
    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit System Notification Event for Testing')
            ->addOption('message', null, InputOption::VALUE_REQUIRED, 'message', null);
    }

    protected function getEventType(): EventType
    {
        return EventType::SystemNotification();
    }
}
