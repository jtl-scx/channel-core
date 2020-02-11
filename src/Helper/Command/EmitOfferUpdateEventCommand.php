<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Client\Channel\Helper\Event\EventType;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmitOfferUpdateEventCommand extends EmitOfferNewEventCommand
{
    protected static $defaultName = 'helper:emit.OfferUpdateEvent';

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Helper command to emit OfferUpdateEvent for Testing');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $this->prepareEventData($input, $output);
        $container = $this->buildEventContainer(EventType::SellerOfferUpdate(), $event);
        $this->emit($container, $input, $output);
    }
}
