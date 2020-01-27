<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/24/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;


use JTL\Nachricht\Contract\Event\Event;
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractEmitEventCommand extends AbstractCommand
{

    protected AmqpEmitter $emitter;

    public function __construct(AmqpEmitter $emitter)
    {
        parent::__construct();
        $this->emitter = $emitter;

    }

    protected function configure()
    {
        $this->addArgument('jsonFile', InputArgument::REQUIRED, 'JSON File contain a OfferNew Event')
            ->addArgument('sellerId', InputArgument::OPTIONAL, 'Associated SellerId', null);
    }

    protected function prepareEvent(InputInterface $input, OutputInterface $output): array
    {
        $jsonFile = $input->getArgument('jsonFile');

        $jsonFile = realpath($jsonFile);
        if (!file_exists($jsonFile)) {
            throw new \RuntimeException("Json File '{$input->getArgument('jsonFile')}' not found");
        }

        $event = json_decode((string)file_get_contents($jsonFile), true);
        $event['sellerId'] = $input->getArgument('sellerId');

        $event = $this->replaceWithArguments($event, $input->getArguments());
        $this->printEventData($output, $event);

        return $event;
    }

    private function replaceWithArguments(array $event, array $arguments): array
    {
        foreach ($arguments as $key => $value) {
            if ($key !== null && isset($event[$key])) {
                $event[$key] = $value;
            }
        }
        return $event;
    }

    private function printEventData(OutputInterface $output, array $event)
    {
        $output->writeln(json_encode($event, JSON_PRETTY_PRINT));
        $output->writeln("");
    }

    protected function emit(Event $event, InputInterface $input, OutputInterface $output)
    {
        $this->emitter->emit($event);
        $output->writeln("Event \"" . get_class($event) . "\" emitted");
    }

}
