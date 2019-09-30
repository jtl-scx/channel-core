<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\RabbitMq\ManagementApi\Queues\Request;

class GetQueuesRequest
{
    /**
     * @var string
     */
    private $vhost;

    /**
     * GetQueuesRequest constructor.
     * @param string $vhost
     */
    public function __construct(string $vhost)
    {
        $this->vhost = $vhost;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }
}
