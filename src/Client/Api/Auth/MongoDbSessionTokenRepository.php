<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Auth;

use JTL\SCX\Client\Auth\Model\SessionToken;
use JTL\SCX\Client\Auth\SessionTokenStorage;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\UTCDateTimeInterface;
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

            if (!isset($result->authToken) || !isset($result->expireAt) || !$result->expireAt instanceof UTCDateTimeInterface) {
                return null;
            }

            $expireAt = \DateTimeImmutable::createFromMutable($result->expireAt->toDateTime());
            $token = new SessionToken((string)$result->authToken, $expireAt);
            $this->sessionTokenMap[$key] = $token;
            return $token;
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
