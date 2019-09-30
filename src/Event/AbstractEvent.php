<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/27
 */

namespace JTL\SCX\Lib\Channel\Event;

use JTL\Nachricht\Event\AbstractAmqpEvent;

abstract class AbstractEvent extends AbstractAmqpEvent
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $type;

    /**
     * AbstractEvent constructor.
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $type
     */
    public function __construct(string $id, \DateTimeImmutable $createdAt, string $type)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->type = $type;
    }
}
