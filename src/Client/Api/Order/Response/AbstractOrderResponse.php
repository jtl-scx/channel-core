<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-03-06
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use JTL\SCX\Lib\Channel\Client\Model\Error;
use JTL\SCX\Client\Response\AbstractResponse;

abstract class AbstractOrderResponse extends AbstractResponse
{
    /**
     * @var Error[]|null
     */
    private ?array $errorList = null;

    /**
     * @param int $statusCode
     * @param Error[] $errorList
     */
    public function __construct(int $statusCode, array $errorList = null)
    {
        parent::__construct($statusCode);
        $this->errorList = $errorList;
    }

    public function hasError(): bool
    {
        return $this->errorList !== null;
    }

    public function orderIdHasError(string $orderId): bool
    {
        foreach ($this->errorList ?? [] as $error) {
            if ($error->getHint() === $orderId) {
                return true;
            }

            if (strpos((string)$error->getMessage(), $orderId) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Error[]|null
     */
    public function getErrorList(): ?array
    {
        return $this->errorList;
    }
}
