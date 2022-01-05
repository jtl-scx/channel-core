<?php declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Api\Seller\Response;

use JTL\SCX\Client\Response\AbstractResponse;

class SignupSessionDataResponse extends AbstractResponse
{
    private int $jtlAccountId;

    public function __construct(int $jtlAccountId, int $statusCode)
    {
        $this->jtlAccountId = $jtlAccountId;
        parent::__construct($statusCode);
    }

    public function getJtlAccountId(): int
    {
        return $this->jtlAccountId;
    }
}
