<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-06-03
 */

namespace JTL\SCX\Lib\Channel\Report\SellerInventory\Client;

use JTL\SCX\Lib\Channel\Client\Api\Report\ReportApi;
use JTL\SCX\Lib\Channel\Client\Api\Report\Request\SendReportRequest;
use JTL\SCX\Lib\Channel\Report\SellerInventory\Model\InventoryItemList;

class SendInventoryReportClient
{
    private ReportApi $reportApi;

    public function __construct(ReportApi $reportApi)
    {
        $this->reportApi = $reportApi;
    }

    /**
     * @param string $sellerReportId
     * @param InventoryItemList $itemList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function sendReport(string $sellerReportId, InventoryItemList $itemList)
    {
        $request = new SendReportRequest($sellerReportId, $itemList->toArray());
        $this->reportApi->sendReport($request);
    }
}
