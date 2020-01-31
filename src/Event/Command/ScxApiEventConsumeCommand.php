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
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Core\Log\ConsoleLogger;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScxApiEventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:get.events';

    private SellerEventEmitter $eventEnqueuer;
    private EventApi $eventApi;
    private LoggerInterface $logger;

    public function __construct(EventApi $eventApi, SellerEventEmitter $eventEmitter, ConsoleLogger $logger)
    {
        parent::__construct();
        $this->eventApi = $eventApi;
        $this->eventEnqueuer = $eventEmitter;
        $this->logger = $logger;
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
            $emittedEventIdList = $this->eventEnqueuer->emit($response->getEventList());
            $this->eventApi->ack(new AcknowledgeEventIdListRequest($emittedEventIdList));
        }
    }
}
