<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\RabbitMq\MessageQueueDiscoverer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends AbstractCommand
{
    protected static $defaultName = 'scx:test';

    /**
     * @var MessageQueueDiscoverer
     */
    private $queueDiscoverer;

    /**
     * TestCommand constructor.
     * @param MessageQueueDiscoverer $queueDiscoverer
     */
    public function __construct(MessageQueueDiscoverer $queueDiscoverer)
    {
        parent::__construct();
        $this->queueDiscoverer = $queueDiscoverer;
    }

    protected function configure()
    {
        $this->setDescription('Test');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->queueDiscoverer->discover();

        var_dump($result);
    }
}
