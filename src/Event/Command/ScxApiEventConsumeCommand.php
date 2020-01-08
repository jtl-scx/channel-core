<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event\Command;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Channel\Api\Event\AcknowledgeEventListApi;
use JTL\SCX\Client\Channel\Api\Event\GetSellerEventListApi;
use JTL\SCX\Client\Channel\Api\Event\Request\AcknowledgeEventIdListRequest;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Client\Exception\RequestValidationFailedException;
use JTL\SCX\Lib\Channel\Contract\Core\Log\ConsoleLogger;
use JTL\SCX\Lib\Channel\Core\Command\AbstractCommand;
use JTL\SCX\Lib\Channel\Event\Emitter\SellerEventEmitter;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScxApiEventConsumeCommand extends AbstractCommand
{
    protected static $defaultName = 'scx-api:event.consume';

    /**
     * @var SellerEventEmitter
     */
    private $eventEnqueuer;

    /**
     * @var GetSellerEventListApi
     */
    private $getSellerEventListApi;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var AcknowledgeEventListApi
     */
    private $ackEventApi;

    /**
     * ScxApiEventConsumeCommand constructor.
     * @param GetSellerEventListApi $getSellerEventListApi
     * @param SellerEventEmitter $eventEmitter
     * @param AcknowledgeEventListApi $ackEventApi
     * @param LoggerInterface $logger
     */
    public function __construct(
        GetSellerEventListApi $getSellerEventListApi,
        SellerEventEmitter $eventEmitter,
        AcknowledgeEventListApi $ackEventApi,
        ConsoleLogger $logger
    ) {
        parent::__construct();
        $this->getSellerEventListApi = $getSellerEventListApi;
        $this->eventEnqueuer = $eventEmitter;
        $this->ackEventApi = $ackEventApi;
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
        $this->logger->info("Hallo!!");
        while (($response = $this->getSellerEventListApi->getEventList())->getEventList()->count() !== 0) {
            $emittedEventIdList = $this->eventEnqueuer->emit($response->getEventList());
            $this->ackEventApi->ack(new AcknowledgeEventIdListRequest($emittedEventIdList));
        }
    }
}
