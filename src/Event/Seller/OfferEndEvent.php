<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOfferEnd;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

class OfferEndEvent extends AbstractEvent
{
    /**
     * @var SellerEventOfferEnd
     */
    private $event;

    /**
     * OfferEndEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventOfferEnd $event
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventOfferEnd $event)
    {
        parent::__construct($id, $createdAt, EventType::SELLER__OFFER_END());
        $this->event = $event;
    }

    /**
     * @return SellerEventOfferEnd
     */
    public function getEvent(): SellerEventOfferEnd
    {
        return $this->event;
    }
}
