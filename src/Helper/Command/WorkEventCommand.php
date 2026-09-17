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
use JTL\SCX\Lib\Channel\Contract\Core\Message\CliConstructable;
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
            'Build an event or message from a JSON payload and run it through its listener(s) '
            . 'synchronously, bypassing RabbitMQ entirely. For e2e testing only.'
        )
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED,
                'EventType constant name, or the FQCN of a class implementing CliConstructable'
            )
            ->addArgument('payload', InputArgument::REQUIRED, 'Path to a JSON file, or a JSON object inline')
            ->addArgument(
                'sellerId',
                InputArgument::OPTIONAL,
                'Associated SellerId, overrides the payload value',
                null
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $typeOption = $input->getOption('type');
        $payload = $this->loadPayload($input);
        $message = $this->buildMessage(is_string($typeOption) ? $typeOption : '', $payload);

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

        return $failures === [] ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @return array<string, mixed>
     */
    private function loadPayload(InputInterface $input): array
    {
        $argument = $input->getArgument('payload');
        $raw = is_string($argument) ? trim($argument) : '';

        // A path never starts with a brace, so this tells an inline object from a file name.
        $json = str_starts_with($raw, '{') ? $raw : $this->readPayloadFile($raw);

        $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($decoded)) {
            throw new RuntimeException('The payload is not a JSON object');
        }

        /** @var array<string, mixed> $payload */
        $payload = $decoded;

        $sellerId = $input->getArgument('sellerId');
        if ($sellerId !== null) {
            $payload['sellerId'] = $sellerId;
        }

        return $payload;
    }

    private function readPayloadFile(string $file): string
    {
        if (strpos($file, '/') !== 0) {
            $file = '/' . $file;
        }

        $absolutePath = $this->environment->get('ROOT_DIRECTORY') . $file;
        if (!file_exists($absolutePath)) {
            $absolutePath = $this->environment->get('ROOT_DIRECTORY') . '/source' . $file;
        }
        if (!file_exists($absolutePath)) {
            throw new RuntimeException("Json File '{$absolutePath}' not found");
        }

        return (string)file_get_contents($absolutePath);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function buildMessage(string $type, array $payload): object
    {
        $constants = EventType::toArray();
        if (array_key_exists($type, $constants)) {
            return $this->buildScxEvent(new EventType($constants[$type]), $payload);
        }

        if (is_subclass_of($type, CliConstructable::class)) {
            return $type::createFrom($payload);
        }

        throw new InvalidArgumentException(
            "'{$type}' is neither an EventType nor a class implementing "
            . CliConstructable::class . '. Known EventTypes: ' . implode(', ', array_keys($constants))
        );
    }

    /**
     * @param array<string, mixed> $event
     */
    private function buildScxEvent(EventType $eventType, array $event): object
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

        // Not every EventType constant has an event class; EventFactory returns null for those.
        if ($message === null) {
            $rawValue = $eventType->getValue();
            $typeValue = is_scalar($rawValue) ? (string)$rawValue : 'unknown';

            throw new InvalidArgumentException(
                "EventType '{$typeValue}' has no event class, nothing to dispatch."
            );
        }

        return $message;
    }
}
