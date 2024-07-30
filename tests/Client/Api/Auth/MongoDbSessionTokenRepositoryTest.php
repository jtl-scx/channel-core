<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Auth;

use JTL\SCX\Client\Auth\Model\SessionToken;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Auth\MongoDbSessionTokenRepository
 */
class MongoDbSessionTokenRepositoryTest extends TestCase
{
    private MongoDbSessionTokenRepository $sut;
    private Stub|UTCDateTimeConverter $dateTimeConverter;
    private Collection|MockObject $collection;

    public function setUp(): void
    {
        $this->collection = $this->createMock(Collection::class);
        $connection = $this->createMock(MongoDbConnection::class);
        $connection->expects(self::once())->method('selectCollection')
            ->willReturn($this->collection);
        $this->dateTimeConverter = $this->createStub(UTCDateTimeConverter::class);
        $this->sut = new MongoDbSessionTokenRepository($connection, $this->dateTimeConverter);
    }

    public function testCanLoadSessionToken(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])
            ->willReturn(['authToken' => 'some_token', 'expireAt' => $expiresAt]);
        $token = $this->sut->load('some_key');
        self::assertSame('some_token', $token->getSessionToken());
        self::assertSame($expiresAt, $token->getExpiresAt());
    }

    public function testCanLoadWithEmptyResult(): void
    {
        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])->willReturn(null);
        self::assertNull($this->sut->load('some_key'));
    }

    public function testCanSaveAndCacheSessionToken(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $token = new SessionToken('some_token', $expiresAt);
        $this->collection->expects(self::once())->method('updateOne');
        $this->collection->expects(self::never())->method('findOne');
        $this->sut->save('some_key', $token);
        self::assertSame($token, $this->sut->load('some_key'));
    }

    public function testCanCacheTokenInMemory(): void
    {
        $expiresAt = new \DateTimeImmutable();
        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])
            ->willReturn(['authToken' => 'some_token', 'expireAt' => $expiresAt]);
        $token = $this->sut->load('some_key');
        self::assertSame($token, $this->sut->load('some_key'));
    }
}
