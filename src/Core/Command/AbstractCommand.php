<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected ScxLogger $logger;

    public function __construct(ScxLogger $logger)
    {
        parent::__construct(null);
        $this->logger = $logger;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $prolog = <<< TXT
  _____  _______   __      _____ _                            _ 
 / ____|/ ____\ \ / /     / ____| |                          | |
| (___ | |     \ V /_____| |    | |__   __ _ _ __  _ __   ___| |
 \___ \| |      > <______| |    | '_ \ / _` | '_ \| '_ \ / _ \ |
 ____) | |____ / . \     | |____| | | | (_| | | | | | | |  __/ |
|_____/ \_____/_/ \_\     \_____|_| |_|\__,_|_| |_|_| |_|\___|_|
powered by JTL-Software-GmbH

TXT;

        $output->writeln($prolog);
        if ($output->isVerbose()) {
            $this->logger->enableStdoutSteam();
        }
    }
}
