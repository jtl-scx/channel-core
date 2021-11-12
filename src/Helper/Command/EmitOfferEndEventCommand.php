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

class EmitOfferEndEventCommand extends AbstractEmitEventCommand
{
    protected static $defaultName = 'helper:emit.OfferEndEvent';

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Helper command to emit OrderShippedEvent for Testing')
            ->addOption('offerId', null, InputOption::VALUE_REQUIRED, 'offerId', null);
    }

    protected function getEventType(): EventType
    {
        return EventType::SellerOfferEnd();
    }
}
