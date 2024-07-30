<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Auth;

use JTL\SCX\Client\Auth\Model\SessionToken;
use JTL\SCX\Client\Auth\SessionTokenStorage;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\Collection;

class MongoDbSessionTokenRepository implements SessionTokenStorage
{
    public const COLLECTION_NAME = 'sessionToken';
    /**
     * @var SessionToken[]
     */
    private array $sessionTokenMap = [];
    private readonly Collection $collection;

    public function __construct(MongoDbConnection $connection, private readonly UTCDateTimeConverter $dateTimeConverter)
    {
        $this->collection = $connection->selectCollection(self::COLLECTION_NAME);
    }

    public function load(string $key): ?SessionToken
    {
        if (!isset($this->sessionTokenMap[$key])) {
            $result = $this->collection->findOne(['key' => $key]);
            if ($result !== null && isset($result['authToken'], $result['expireAt']) && $result['expireAt'] instanceof \DateTimeInterface) {
                $token = new SessionToken((string)$result['authToken'], $result['expireAt']);
                $this->sessionTokenMap[$key] = $token;
                return $token;
            }
            return null;
        }

        return $this->sessionTokenMap[$key];
    }

    public function save(string $key, SessionToken $authToken): void
    {
        $this->collection->updateOne(
            [
                'key' => $key
            ],
            [
                '$set' => [
                    'key' => $key,
                    'authToken' => $authToken->getSessionToken(),
                    'expireAt' => $this->dateTimeConverter->create($authToken->getExpiresAt())
                ],
            ],
            ['upsert' => true]
        );
        $this->sessionTokenMap[$key] = $authToken;
    }
}
