<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-01-26
 */

namespace JTL\SCX\Lib\Channel\Core\Lock;

use JTL\SCX\Lib\Channel\Core\Lock\MongoDbLockProvider;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use MongoDB\DeleteResult;
use MongoDB\Exception\RuntimeException;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\Lock\MongoDbLockProvider
 */
class MongoDbLockProviderTest extends TestCase
{
    public function testCanDelete(): void
    {
        $key = uniqid('key', true);

        $deleteResult = $this->createMock(DeleteResult::class);
        $deleteResult->expects(self::once())->method('getDeletedCount')->willReturn(1);
        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('deleteMany')->with(['lockKey' => $key])->willReturn($deleteResult);
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertTrue($provider->delete($key));
    }

    public function testCanCheckIsset(): void
    {
        $key = uniqid('key', true);

        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('findOne')->with(['lockKey' => $key])->willReturn(new \stdClass());
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertTrue($provider->isset($key));
    }

    public function testCanCheckNotIsset(): void
    {
        $key = uniqid('key', true);

        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('findOne')->with(['lockKey' => $key])->willReturn(null);
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertFalse($provider->isset($key));
    }

    public function testCanExtend(): void
    {
        $key = uniqid('key', true);
        $expireAt = new \DateTimeImmutable();

        $updateResult = $this->createMock(UpdateResult::class);
        $updateResult->expects(self::once())->method('isAcknowledged')->willReturn(true);
        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('updateOne')
            ->with(['lockKey' => $key], self::arrayHasKey('$set'), ['upsert' => true])
            ->willReturn($updateResult);
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $dateTimeConverter->expects(self::once())->method('create')->with($expireAt);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertTrue($provider->extend($key, $expireAt));
    }

    public function testCanExtendWillFail(): void
    {
        $key = uniqid('key', true);
        $expireAt = new \DateTimeImmutable();

        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('updateOne')
            ->willThrowException($this->createStub(RuntimeException::class));
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $dateTimeConverter->expects(self::once())->method('create')->with($expireAt);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertFalse($provider->extend($key, $expireAt));
    }

    public function testCanObtain(): void
    {
        $key = uniqid('key', true);
        $expireAt = new \DateTimeImmutable();
        $expireAtUTCDate = new UTCDateTime(random_int(1, 99));

        $insertResult = $this->createMock(InsertOneResult::class);
        $insertResult->expects(self::once())->method('getInsertedCount')->willReturn(1);
        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('insertOne')
            ->with(['lockKey' => $key, 'expireAt' => $expireAtUTCDate])
            ->willReturn($insertResult);
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $dateTimeConverter->expects(self::once())->method('create')->with($expireAt)->willReturn($expireAtUTCDate);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertTrue($provider->obtain($key, $expireAt));
    }

    public function testObtainCanFail(): void
    {
        $key = uniqid('key', true);
        $expireAt = new \DateTimeImmutable();
        $expireAtUTCDate = new UTCDateTime(random_int(1, 99));

        $collection = $this->createMock(Collection::class);
        $collection->expects(self::once())->method('insertOne')
            ->willThrowException($this->createStub(RuntimeException::class));
        $mongoConnection = $this->createMock(MongoDbConnection::class);
        $mongoConnection->expects(self::once())->method('selectCollection')
            ->with('lock')
            ->willReturn($collection);
        $dateTimeConverter = $this->createMock(UTCDateTimeConverter::class);
        $dateTimeConverter->expects(self::once())->method('create')->with($expireAt)->willReturn($expireAtUTCDate);
        $provider = new MongoDbLockProvider($mongoConnection, $dateTimeConverter);

        self::assertFalse($provider->obtain($key, $expireAt));
    }
}
