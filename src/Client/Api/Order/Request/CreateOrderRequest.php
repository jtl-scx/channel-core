<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/20
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Request;

use JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest;
use JTL\SCX\Lib\Channel\Client\Model\OrderList;
use JTL\SCX\Client\Request\ScxApiRequest;

class CreateOrderRequest extends AbstractScxApiRequest
{
    private OrderList $orderList;

    public function __construct(OrderList $orderList)
    {
        $this->orderList = $orderList;
    }

    public function getOrderList(): OrderList
    {
        return $this->orderList;
    }

    public function getUrl(): string
    {
        return '/v1/channel/order';
    }

    public function getHttpMethod(): string
    {
        return ScxApiRequest::HTTP_METHOD_POST;
    }

    public function getBody(): ?string
    {
        return (string)$this->getOrderList();
    }
}
