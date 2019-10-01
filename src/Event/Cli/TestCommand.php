<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Cli;

use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;

class TestCommand extends AbstractCommand
{
    protected static $defaultName = 'scx:test';

}
