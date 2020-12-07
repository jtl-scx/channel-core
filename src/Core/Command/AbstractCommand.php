<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Log\EntityIdContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCommand extends Command
{
    protected ScxLogger $logger;
    protected SymfonyStyle $io;

    public function __construct(ScxLogger $logger)
    {
        parent::__construct(null);
        $this->logger = $logger;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);

        $prolog = <<< TXT
SCX-Channel-Core command {$this->getName()} by JTL-Software-GmbH. 

TXT;

        $entityId = (string)$input->getOption('entity');
        $this->logger->replaceContext(new EntityIdContext($entityId));

        $output->writeln($prolog);
        if ($output->isVerbose()) {
            $this->logger->enableStdoutStream();
        }
    }
}
