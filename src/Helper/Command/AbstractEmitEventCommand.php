<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/24/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;


use DateTimeImmutable;
use JTL\Nachricht\Contract\Event\Event;
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Channel\Helper\Event\EventType;
use JTL\SCX\Client\ObjectSerializer;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractEmitEventCommand extends AbstractCommand
{

    protected AmqpEmitter $emitter;
    protected EventFactory $eventFactory;
    private Environment $environment;

    public function __construct(Environment $environment, EventFactory $eventFactory, AmqpEmitter $emitter)
    {
        parent::__construct();
        $this->emitter = $emitter;
        $this->environment = $environment;
        $this->eventFactory = $eventFactory;
    }

    protected function configure()
    {
        $this->addArgument('jsonFile', InputArgument::REQUIRED, 'JSON File contain a OfferNew Event')
            ->addArgument('sellerId', InputArgument::OPTIONAL, 'Associated SellerId', null);
    }

    protected function prepareEventData(InputInterface $input, OutputInterface $output): array
    {
        $absoluteJsonFilePath = $this->getAbsoluteJsonFilePath($input);
        $event = json_decode((string)file_get_contents($absoluteJsonFilePath), true);
        $event['sellerId'] = $input->getArgument('sellerId');

        $event = $this->replaceWithArguments($event, $input->getArguments());
        $this->printEventData($output, $event);

        return $event;
    }

    protected function buildEventContainer(EventType $eventType, array $event)
    {
        return $this->eventFactory->createFromEventContainer(new EventContainer(
            uniqid(static::getName()),
            new DateTimeImmutable('now'),
            $eventType->getValue(),
            ObjectSerializer::deserialize(json_encode($event), $eventType->getEventModelClass())
        ));
    }

    protected function emit(Event $event, InputInterface $input, OutputInterface $output)
    {
        $this->emitter->emit($event);
        $output->writeln("Event \"" . get_class($event) . "\" emitted");
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function getAbsoluteJsonFilePath(InputInterface $input): string
    {
        $jsonFile = $input->getArgument('jsonFile');
        if (substr($jsonFile, 0, 1) !== '/') {
            $jsonFile = '/' . $jsonFile;
        }

        $absoluteJsonFilePath = $this->environment->get('ROOT_DIRECTORY') . $jsonFile;
        if (!file_exists($absoluteJsonFilePath)) {
            throw new RuntimeException("Json File '{$absoluteJsonFilePath}' not found ");
        }
        return $absoluteJsonFilePath;
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

}
