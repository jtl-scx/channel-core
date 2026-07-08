<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/18
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Channel\Response;

use JTL\SCX\Lib\Channel\Client\Model\SalesChannel;
use JTL\SCX\Client\Response\AbstractResponse;

class GetChannelStatusResponse extends AbstractResponse
{
    private SalesChannel $salesChannel;

    /**
     * GetChannelStatusResponse constructor.
     * @param SalesChannel $salesChannel
     * @param int $statusCode
     */
    public function __construct(SalesChannel $salesChannel, int $statusCode)
    {
        $this->salesChannel = $salesChannel;
        parent::__construct($statusCode);
    }

    /**
     * @return SalesChannel
     */
    public function getSalesChannel(): SalesChannel
    {
        return $this->salesChannel;
    }
}
