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
use JTL\Nachricht\Emitter\AmqpEmitter;
use JTL\Nachricht\Message\AbstractAmqpTransportableMessage;
use JTL\SCX\Client\Channel\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Client\Channel\Api\Event\Model\EventContainer;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\ModelInterface;
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

    private ChannelApiResponseDeserializer $responseDeserializer;

    public function __construct(
        Environment $environment,
        EventFactory $eventFactory,
        AmqpEmitter $emitter,
        ChannelApiResponseDeserializer $responseDeserializer,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
        $this->environment = $environment;
        $this->eventFactory = $eventFactory;
        $this->emitter = $emitter;
        $this->responseDeserializer = $responseDeserializer;
    }

    protected function configure(): void
    {
        $this->setDescription("Helper command to emit {$this->getEventType()} for Testing");
        $this->addArgument('jsonFile', InputArgument::REQUIRED, 'JSON File contain a OfferNew Event')
            ->addArgument('sellerId', InputArgument::OPTIONAL, 'Associated SellerId', null);
    }

    abstract protected function getEventType(): EventType;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $event = $this->prepareEventData($input, $output);
        $container = $this->buildEventContainer($this->getEventType(), $event);
        if (!$container instanceof AbstractAmqpTransportableMessage) {
            throw new RuntimeException("Fail to build AmqpEvent. Nothing to emit.");
        }
        $this->emit($container, $output);

        return 0;
    }

    protected function prepareEventData(InputInterface $input, OutputInterface $output): array
    {
        $absoluteJsonFilePath = $this->getAbsoluteJsonFilePath($input);
        $event = json_decode((string)file_get_contents($absoluteJsonFilePath), true, 512, JSON_THROW_ON_ERROR);
        $event['sellerId'] = $input->getArgument('sellerId') ?? $event['sellerId'];

        $event = $this->replaceWithArguments($event, $input->getOptions() + $input->getArguments());
        $this->printEventData($output, $event);

        return $event;
    }

    protected function buildEventContainer(EventType $eventType, array $event): ?AbstractAmqpTransportableMessage
    {
        $model = $this->responseDeserializer->deserializeObject(
            json_encode($event, JSON_THROW_ON_ERROR),
            $eventType->getEventModelClass()
        );

        if ($model instanceof ModelInterface && method_exists($model, 'valid') && !$model->valid()) {
            throw new InvalidArgumentException(
                "Invalid event schema \n" . print_r($model->listInvalidProperties(), true)
            );
        }

        return $this->eventFactory->createFromEventContainer(new EventContainer(
            uniqid($this->getName()),
            new DateTimeImmutable('now'),
            $eventType,
            $model
        ));
    }

    protected function emit(AbstractAmqpTransportableMessage $event, OutputInterface $output): void
    {
        $this->emitter->emit($event);
        $output->writeln("Event '" . get_class($event) . "' emitted");
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function getAbsoluteJsonFilePath(InputInterface $input): string
    {
        $jsonFile = $input->getArgument('jsonFile');
        if (strpos($jsonFile, '/') !== 0) {
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

    private function printEventData(OutputInterface $output, array $event): void
    {
        $output->writeln(json_encode($event, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
        $output->writeln('');
    }
}
