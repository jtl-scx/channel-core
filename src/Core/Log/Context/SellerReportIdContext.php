<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

class SellerReportIdContext implements ContextAware
{
    private string $sellerReportId;

    public function __construct(string $sellerReportId)
    {
        $this->sellerReportId = $sellerReportId;
    }

    public function __invoke(array $record): array
    {
        $record['sellerReportId'] = $this->sellerReportId;
        $record['label'][] = 'report';
        $record['label'][] = 'seller';
        $record['label'] = array_unique($record['label']);
        return $record;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }
}
