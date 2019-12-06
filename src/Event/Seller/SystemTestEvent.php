<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class SystemTestEvent extends AbstractEvent
{
    /**
     * @var SellerEventTest
     */
    private $event;

    /**
     * SystemTestEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventTest $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventTest $event)
    {
        parent::__construct($id, $createdAt, EventType::SYSTEM__TEST());
        $this->event = $event;
    }

    /**
     * @return SellerEventTest
     */
    public function getEvent(): SellerEventTest
    {
        return $this->event;
    }
}
