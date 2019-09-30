<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Response;

use JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Model\Queue;

class GetQueuesResponse
{
    /**
     * @var Queue[]
     */
    private $queueList;

    /**
     * GetQueuesResponse constructor.
     * @param Queue[] $queueList
     */
    public function __construct(array $queueList)
    {
        $this->queueList = $queueList;
    }

    /**
     * @return Queue[]
     */
    public function getQueueList(): array
    {
        return $this->queueList;
    }
}
