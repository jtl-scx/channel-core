<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SellerEventEnqueuerCommand extends AbstractCommand
{
    protected static $defaultName = 'scx:event:enqueue';

    /**
     * @var SellerEventEmitter
     */
    private $eventEnqueuer;

    public function __construct(SellerEventEmitter $eventEmitter)
    {
        parent::__construct();
        $this->eventEnqueuer = $eventEmitter;
    }

    protected function configure()
    {
        $this->setDescription('Consume seller events created from polling the SCX Channel API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventEnqueuer->emit();
    }
}
