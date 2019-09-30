<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use JTL\SCX\Client\Request\UrlFactory;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Configuration;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Model\Queue;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Request\GetQueuesRequest;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Response\GetQueuesResponse;

class GetQueuesApi
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var UrlFactory
     */
    private $urlFactory;

    /**
     * GetQueuesApi constructor.
     * @param ClientInterface $client
     * @param Configuration $configuration
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        Configuration $configuration,
        UrlFactory $urlFactory = null,
        ClientInterface $client = null
    ) {
        $this->client = $client ?? new Client();
        $this->urlFactory = $urlFactory ?? new UrlFactory();
        $this->configuration = $configuration;
    }

    /**
     * @param GetQueuesRequest $request
     * @return GetQueuesResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getQueues(GetQueuesRequest $request): GetQueuesResponse
    {
        $vhost = $request->getVhost() === '/' ? '' : $request->getVhost();

        $url = $this->urlFactory->create(
            $this->configuration->getHost(),
            '/api/queues/{vhost}',
            ['vhost' => $vhost]
        );

        $response = $this->client->request('GET', $url, [
            'auth' => [
                $this->configuration->getUsername(),
                $this->configuration->getPassword()
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        $queueList = [];

        foreach ($responseData as $queue) {
            $queueList[] = new Queue($queue['name']);
        }

        return new GetQueuesResponse($queueList);
    }
}
