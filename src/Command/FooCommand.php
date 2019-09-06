<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/06
 */

namespace JTL\SCX\Channel\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FooCommand extends Command
{
    protected static $defaultName = 'scx:foo-command';

    protected function configure(): void
    {
        $this->setName('scx:foo-command')
            ->setDescription('Foo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Foo");
        return 0;
    }
}