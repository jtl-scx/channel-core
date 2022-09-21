<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 7/6/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api;

use JTL\SCX\Lib\Channel\Client\ObjectSerializer;
use Psr\Http\Message\ResponseInterface;

class ChannelApiResponseDeserializer
{
    public function deserialize(ResponseInterface $response, string $openApiModel): object
    {
        return $this->deserializeObject($response->getBody()->getContents(), $openApiModel);
    }

    /**
     * @param mixed $data
     * @param string $openApiModel
     * @return object
     */
    public function deserializeObject($data, string $openApiModel): object
    {
        $result = ObjectSerializer::deserialize($data, $openApiModel);
        if (is_object($result)) {
            return $result;
        }

        throw new \RuntimeException(
            "Deserialize process expect to return a object. " . gettype($result) . " returned"
        );
    }
}
