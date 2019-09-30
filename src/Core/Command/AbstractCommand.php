<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Lib\Channel\Core\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    public function __construct()
    {
        parent::__construct(null);
    }
}
