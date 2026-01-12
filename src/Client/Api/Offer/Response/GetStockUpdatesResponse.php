<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Offer\Response;

use JTL\SCX\Client\Response\AbstractResponse;
use JTL\SCX\Lib\Channel\Client\Model\StockList;

class GetStockUpdatesResponse extends AbstractResponse
{
    private StockList $stockList;

    public function __construct(StockList $stockList, int $statusCode)
    {
        $this->stockList = $stockList;
        parent::__construct($statusCode);
    }

    public function getStockList(): StockList
    {
        return $this->stockList;
    }
}
