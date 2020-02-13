<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/24/20
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use DateTimeImmutable;
use Exception;
use InvalidArgumentException;
use JTL\Nachricht\Contract\Event\Event;
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Channel\Helper\Event\EventType;
use JTL\SCX\Client\ResponseDeserializer;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
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
    private ResponseDeserializer $responseDeserializer;

    public function __construct(
        Environment $environment,
        EventFactory $eventFactory,
        AmqpEmitter $emitter,
        ResponseDeserializer $responseDeserializer,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->emitter = $emitter;
        $this->environment = $environment;
        $this->eventFactory = $eventFactory;
        $this->responseDeserializer = $responseDeserializer;
    }

    protected function configure()
    {
        $this->setDescription("Helper command to emit " . $this->getEventType() . " for Testing");
        $this->addArgument('jsonFile', InputArgument::REQUIRED, 'JSON File contain a OfferNew Event')
            ->addArgument('sellerId', InputArgument::OPTIONAL, 'Associated SellerId', null);
    }

    abstract protected function getEventType(): EventType;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $this->prepareEventData($input, $output);
        $container = $this->buildEventContainer($this->getEventType(), $event);
        $this->emit($container, $input, $output);
    }

    protected function prepareEventData(InputInterface $input, OutputInterface $output): array
    {
        $absoluteJsonFilePath = $this->getAbsoluteJsonFilePath($input);
        $event = json_decode((string)file_get_contents($absoluteJsonFilePath), true);
        $event['sellerId'] = $input->getArgument('sellerId');

        $event = $this->replaceWithArguments($event, $input->getOptions() + $input->getArguments());
        $this->printEventData($output, $event);

        return $event;
    }

    protected function buildEventContainer(EventType $eventType, array $event)
    {
        $model = $this->responseDeserializer->deserializeObject(json_encode($event), $eventType->getEventModelClass());
        if (method_exists($model, 'valid') && !$model->valid()) {
            throw new InvalidArgumentException(print_r($model->listInvalidProperties(), true));
        }

        return $this->eventFactory->createFromEventContainer(new EventContainer(
            uniqid(static::getName()),
            new DateTimeImmutable('now'),
            $eventType->getValue(),
            $model
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
            if ($value !== null && isset($event[$key])) {
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
