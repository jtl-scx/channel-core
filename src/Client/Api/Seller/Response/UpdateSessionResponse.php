<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class UpdateSessionResponse extends AbstractResponse
{
    private string $sellerId;

    public function __construct(string $sellerId, int $statusCode)
    {
        $this->sellerId = $sellerId;
        parent::__construct($statusCode);
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }
}
