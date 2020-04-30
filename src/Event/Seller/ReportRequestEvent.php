<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-30
 */

namespace JTL\SCX\Lib\Channel\Event\Seller;

use DateTimeImmutable;
use JTL\SCX\Client\Channel\Event\EventType;
use JTL\SCX\Client\Channel\Model\SellerEventReportRequest;
use JTL\SCX\Lib\Channel\Event\AbstractEvent;

class ReportRequestEvent extends AbstractEvent
{
    /**
     * @var SellerEventReportRequest
     */
    private SellerEventReportRequest $event;

    public function __construct(
        string $id,
        DateTimeImmutable $createdAt,
        SellerEventReportRequest $event,
        string $internalEventId = null
    ) {
        parent::__construct($id, $createdAt, EventType::SellerReportRequest(), $internalEventId);
        $this->event = $event;
    }

    public function getEvent(): SellerEventReportRequest
    {
        return $this->event;
    }
}
