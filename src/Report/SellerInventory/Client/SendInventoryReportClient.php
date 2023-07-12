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
use JTL\SCX\Lib\Channel\Client\Api\Report\Request\CompleteReportRequest;
use JTL\SCX\Lib\Channel\Client\Api\Report\Request\SendReportDataRequest;
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
     * @deprecated
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

    /**
     * @param string $sellerReportId
     * @param InventoryItemList $itemList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function sendReportData(string $sellerReportId, InventoryItemList $itemList)
    {
        $request = new SendReportDataRequest($sellerReportId, $itemList->toArray());
        $this->reportApi->sendReportData($request);
    }

    /**
     * @param string $sellerReportId
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JTL\SCX\Client\Exception\RequestFailedException
     */
    public function completeReport(string $sellerReportId)
    {
        $request = new CompleteReportRequest($sellerReportId);
        $this->reportApi->completeReport($request);
    }
}
