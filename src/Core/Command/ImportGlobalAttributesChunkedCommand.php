<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Core\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Contract\MetaData\ChunkedGlobalAttributeLoader;
use JTL\SCX\Lib\Channel\MetaData\Attribute\AttributeList;
use JTL\SCX\Lib\Channel\MetaData\Attribute\GlobalAttributeSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Memory bounded variant of ImportGlobalAttributesCommand.
 *
 * Instead of loading every global attribute into one list and pushing it to SCX in a single
 * request, this command consumes the loader chunk by chunk and sends each chunk right away. The
 * SCX-API upserts attributes individually, so the result is the same while peak memory stays
 * bound to the largest single chunk.
 */
#[AsCommand(name: 'scx-api:put.attributes-global-chunked')]
class ImportGlobalAttributesChunkedCommand extends AbstractCommand
{
    private ChunkedGlobalAttributeLoader $globalAttributeLoader;
    private GlobalAttributeSender $globalAttributeSender;

    public function __construct(
        ChunkedGlobalAttributeLoader $globalAttributeLoader,
        GlobalAttributeSender $globalAttributeSender,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->globalAttributeLoader = $globalAttributeLoader;
        $this->globalAttributeSender = $globalAttributeSender;
    }

    protected function configure(): void
    {
        $this->setDescription('Import global attributes chunk by chunk and push them to SCX');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $total = 0;

        /** @var AttributeList $chunk */
        foreach ($this->globalAttributeLoader->loadChunked() as $chunk) {
            $this->globalAttributeSender->send($chunk);

            $total += $chunk->count();
            $output->writeln("Sent {$chunk->count()} global Attributes ({$total} in total)");
        }

        $output->writeln("Successfully sent {$total} global Attributes to SCX");

        return 0;
    }
}
