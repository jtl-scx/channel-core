<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Lib\Channel\Client\Api\Event\EventApi;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Request\GetEventListRequest;
use JTL\SCX\Lib\Channel\Client\Api\Event\Response\GetSellerEventListResponse;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ScxApiEventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:get.events';

    private SellerEventEmitter $eventEnqueuer;
    private EventApi $eventApi;

    public function __construct(EventApi $eventApi, SellerEventEmitter $messageEmitter, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->eventApi = $eventApi;
        $this->eventEnqueuer = $messageEmitter;
    }

    protected function configure(): void
    {
        $this->setDescription('Consume seller events created from polling the SCX Channel API');
        $this->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Limit the number of events to consume', 1000);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = (int)$input->getOption('limit');
        $this->logger->info("Start consuming seller events with limit: {$limit}");
        $request = new GetEventListRequest($limit);

        do {
            $response = $this->eventApi->get($request);

            $withError = count($response->getErroneousEvents());
            $this->logger->info(
                "Receive {$response->getEventList()->count()} events from scx-channel Api (erroneous: {$withError})"
            );

            if ($withError > 0) {
                $this->logErroneousEvents($response);
            }

            if ($response->getEventList()->count() <= 0) {
                break;
            }

            $emittedEventIdList = $this->eventEnqueuer->emit($response->getEventList());
            $emittedEventCount = count($emittedEventIdList);
            $this->logger->info($emittedEventCount . " events emitted.");

            if ($emittedEventCount === 0) {
                continue;
            }

            $this->eventApi->ack(new AcknowledgeEventIdListRequest($emittedEventIdList));
            $this->logger->info("Events successful acknowledged");
        } while (true);

        return 0;
    }

    /**
     * @param GetSellerEventListResponse $response
     */
    protected function logErroneousEvents(GetSellerEventListResponse $response): void
    {
        foreach ($response->getErroneousEvents() as $err) {
            $exceptionClass = "";
            if ($err->getException() !== null) {
                $exceptionClass = "[" . get_class($err->getException()) . "] ";
            }
            $this->logger->warning(
                "Erroneous Event ignored - {$exceptionClass}{$err->getErrorMessage()} - {$err->getEventJson()}"
            );
        }
    }
}
