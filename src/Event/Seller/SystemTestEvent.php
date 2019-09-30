<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use JTL\SCX\Client\Channel\Model\SellerEventTest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class SystemTestEvent extends AbstractEvent
{
    /**
     * @var SellerEventTest
     */
    private $event;

    /**
     * SystemTestEvent constructor.
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $type
     * @param SellerEventTest $event
     */
    public function __construct(
        string $id,
        \DateTimeImmutable $createdAt,
        string $type,
        SellerEventTest $event
    ) {
        parent::__construct($id, $createdAt, $type);
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
