<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 12/6/19
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;


use DateTimeImmutable;
use JTL\SCX\Client\Channel\Model\SellerEventOfferNew;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;
use JTL\SCX\Lib\Channel\Event\EventType;

/**
 * Class OfferNewEvent
 * @package JTL\SCX\Lib\Channel\Event\Seller
 */
class OfferNewEvent extends AbstractEvent
{
    /**
     * @var SellerEventOfferNew
     */
    private $eventOfferNew;

    /**
     * OfferNewEvent constructor.
     * @param string $id
     * @param DateTimeImmutable $createdAt
     * @param SellerEventOfferNew $eventOfferNew
     */
    public function __construct(string $id, DateTimeImmutable $createdAt, SellerEventOfferNew $eventOfferNew)
    {
        parent::__construct($id, $createdAt, EventType::SELLER__OFFER_NEW());
        $this->eventOfferNew = $eventOfferNew;
    }

    /**
     * @return SellerEventOfferNew
     */
    public function getEvent(): SellerEventOfferNew
    {
        return $this->eventOfferNew;
    }


}
