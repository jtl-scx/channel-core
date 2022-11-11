<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-11-25
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

class SellerReportIdContext extends LabeledContextAware
{
    private string $sellerReportId;

    public function __construct(string $sellerReportId)
    {
        $this->sellerReportId = $sellerReportId;
    }

    public function createContextInstance(): callable
    {
        return $this;
    }

    protected function getLabels(): array
    {
        return [
            ContextLabel::report,
            ContextLabel::seller,
        ];
    }

    protected function getLogContext(): array
    {
        return ['sellerReportId' => $this->sellerReportId];
    }
}
