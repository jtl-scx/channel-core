<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Event\EventApi;
use JTL\SCX\Client\Channel\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Client\Channel\Api\Event\Request\GetEventListRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ScxLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScxApiEventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:get.events';

    private SellerEventEmitter $eventEnqueuer;
    private EventApi $eventApi;

    public function __construct(EventApi $eventApi, SellerEventEmitter $eventEmitter, ScxLogger $logger)
    {
        parent::__construct($logger);
        $this->eventApi = $eventApi;
        $this->eventEnqueuer = $eventEmitter;
    }

    protected function configure()
    {
        $this->setDescription('Consume seller events created from polling the SCX Channel API');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws GuzzleException
     * @throws RequestFailedException
     * @throws RequestValidationFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        while (($response = $this->eventApi->getEventList(new GetEventListRequest()))->getEventList()->count() !== 0) {
            $this->logger->info("Receive {$response->getEventList()->count()} events from scx-channel api");
            $emittedEventIdList = $this->eventEnqueuer->emit($response->getEventList());

            $this->logger->info(count($emittedEventIdList) . " events emitted.");
            $this->eventApi->ack(new AcknowledgeEventIdListRequest($emittedEventIdList));
            $this->logger->info("Events successful acknowledged");
        }
    }
}
