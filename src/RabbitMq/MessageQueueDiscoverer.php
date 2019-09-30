<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\RabbitMq;

use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\GetQueuesApi;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Model\Queue;
use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Request\GetQueuesRequest;

class MessageQueueDiscoverer
{
    /**
     * @var GetQueuesApi
     */
    private $getQueuesApi;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * QueueDiscoverer constructor.
     * @param GetQueuesApi $getQueuesApi
     * @param Environment $environment
     */
    public function __construct(GetQueuesApi $getQueuesApi, Environment $environment)
    {
        $this->getQueuesApi = $getQueuesApi;
        $this->environment = $environment;
    }

    /**
     * @return Queue[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function discover(): array
    {
        $request = new GetQueuesRequest($this->environment->get('RABBITMQ_VHOST'));
        $response = $this->getQueuesApi->getQueues($request);

        return array_filter($response->getQueueList(), function (Queue $queue) {
            return $this->startsWith($queue->getName(), 'msg__');
        });
    }

    /**
     * @param string $value
     * @param string $search
     * @return bool
     */
    private function startsWith(string $value, string $search): bool
    {
        return (substr($value, 0, strlen($search)) === $search);
    }
}
