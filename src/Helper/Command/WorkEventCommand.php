<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use DateTimeImmutable;
use InvalidArgumentException;
use JTL\Nachricht\Message\Cache\MessageCache;
use JTL\SCX\Lib\Channel\Client\Api\ChannelApiResponseDeserializer;
use JTL\SCX\Lib\Channel\Client\Api\Event\Model\EventContainer;
use JTL\SCX\Lib\Channel\Client\Event\EventType;
use JTL\SCX\Lib\Channel\Client\Model\ModelInterface;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\Event\EventFactory;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * EA-7972: e2e-test helper. Builds any EventType from a JSON fixture and runs it through every
 * registered listener synchronously, in-process — no RabbitMQ publish/consume round-trip.
 * Unlike the production AmqpDispatcher, a listener exception here is NOT swallowed: it is
 * reported in the JSON output and turns the process exit code non-zero, so a test runner can
 * react to both without parsing logs.
 */
#[AsCommand(name: 'helper:work')]
class WorkEventCommand extends AbstractCommand
{
    public function __construct(
        private readonly Environment $environment,
        private readonly EventFactory $eventFactory,
        private readonly ChannelApiResponseDeserializer $responseDeserializer,
        private readonly MessageCache $messageCache,
        private readonly ContainerInterface $container,
        ScxLogger $logger
    ) {
        parent::__construct($logger);
    }

    protected function configure(): void
    {
        $this->setDescription(
            'Build any EventType from a JSON fixture and run it through its listener(s) '
            . 'synchronously, bypassing RabbitMQ entirely. For e2e testing only.'
        )
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'EventType constant name, e.g. SellerMetaSellerAttributesUpdateRequest'
            )
            ->addArgument('jsonFile', InputArgument::REQUIRED, 'Path to a JSON fixture for the event model')
            ->addArgument(
                'sellerId',
                InputArgument::OPTIONAL,
                'Associated SellerId, overrides the JSON file value',
                null
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $eventType = $this->resolveEventType((string)$input->getOption('type'));
        $event = $this->loadEventData($input);
        $message = $this->buildMessage($eventType, $event);

        $listeners = $this->messageCache->getListenerListForMessage(get_class($message));

        $invoked = [];
        $failures = [];
        foreach ($listeners as $listener) {
            $listenerInstance = $this->container->get($listener['listenerClass']);
            $method = $listener['method'];
            try {
                $listenerInstance->{$method}($message);
                $invoked[] = "{$listener['listenerClass']}::{$method}";
            } catch (Throwable $e) {
                $failures[] = [
                    'listener' => "{$listener['listenerClass']}::{$method}",
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ];
            }
        }

        $output->writeln(json_encode(
            ['listenersInvoked' => $invoked, 'failures' => $failures],
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
        ));

        return $failures === [] ? 0 : 1;
    }

    private function resolveEventType(string $typeName): EventType
    {
        $constants = EventType::toArray();
        if (!array_key_exists($typeName, $constants)) {
            throw new InvalidArgumentException(
                "Unknown EventType '{$typeName}'. Known: " . implode(', ', array_keys($constants))
            );
        }

        /** @var EventType $eventType */
        $eventType = call_user_func([EventType::class, $typeName]);

        return $eventType;
    }

    private function loadEventData(InputInterface $input): array
    {
        $jsonFile = (string)$input->getArgument('jsonFile');
        if (strpos($jsonFile, '/') !== 0) {
            $jsonFile = '/' . $jsonFile;
        }

        $absolutePath = $this->environment->get('ROOT_DIRECTORY') . $jsonFile;
        if (!file_exists($absolutePath)) {
            $absolutePath = $this->environment->get('ROOT_DIRECTORY') . '/source' . $jsonFile;
        }
        if (!file_exists($absolutePath)) {
            throw new RuntimeException("Json File '{$absolutePath}' not found");
        }

        $event = json_decode((string)file_get_contents($absolutePath), true, 512, JSON_THROW_ON_ERROR);

        $sellerId = $input->getArgument('sellerId');
        if ($sellerId !== null) {
            $event['sellerId'] = $sellerId;
        }

        return $event;
    }

    private function buildMessage(EventType $eventType, array $event): object
    {
        $model = $this->responseDeserializer->deserializeObject(
            json_encode($event, JSON_THROW_ON_ERROR),
            $eventType->getEventModelClass()
        );

        if ($model instanceof ModelInterface && !$model->valid()) {
            throw new InvalidArgumentException(
                "Invalid event schema \n" . print_r($model->listInvalidProperties(), true)
            );
        }

        $message = $this->eventFactory->createFromEventContainer(new EventContainer(
            uniqid('helper-work-'),
            new DateTimeImmutable('now'),
            uniqid('clientVersion', true),
            $eventType,
            $model
        ));

        // EventFactory returns null for EventTypes it has no event class for (e.g. Unknown),
        // which is a valid enum constant and therefore passes resolveEventType().
        if ($message === null) {
            throw new InvalidArgumentException(
                "EventType '{$eventType->getValue()}' has no event class, nothing to dispatch."
            );
        }

        return $message;
    }
}
