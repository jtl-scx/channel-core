<?php

namespace JTL\SCX\Lib\Channel\Client\Api\Auth;

use JTL\SCX\Client\Auth\Model\SessionToken;
use JTL\SCX\Lib\Channel\Database\MongoDbConnection;
use JTL\SCX\Lib\Channel\Database\UTCDateTimeConverter;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\UTCDateTimeInterface;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;
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

    /**
     * @test
     */
    public function it_load_existing_session_token_from_Collection(): void
    {
        $expiresAt = new UTCDateTime(new \DateTimeImmutable('@171982'));

        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])
            ->willReturn(new BSONDocument(['authToken' => 'some_token', 'expireAt' => $expiresAt]));

        $token = $this->sut->load('some_key');
        self::assertInstanceOf(SessionToken::class, $token);
        self::assertSame('some_token', $token->getSessionToken());
        self::assertEquals(171982, $token->getExpiresAt()->getTimestamp());
    }

    /**
     * @test
     */
    public function it_return_null_then_results_in_collection(): void
    {
        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])
            ->willReturn(null);

        self::assertNull($this->sut->load('some_key'));
    }

    /**
     * @test
     */
    public function it_will_load_session_token_only_once_from_Collection(): void
    {
        $expiresAt = new UTCDateTime(new \DateTimeImmutable('@171982'));

        $this->collection->expects(self::once())->method('findOne')
            ->with(['key' => 'some_key'])
            ->willReturn(new BSONDocument(['authToken' => 'some_token', 'expireAt' => $expiresAt]));

        $token = $this->sut->load('some_key');
        self::assertInstanceOf(SessionToken::class, $token);

        $reloadedToken = $this->sut->load('some_key');
        self::assertSame($token, $reloadedToken);
    }


    /**
     * @test
     */
    public function it_save_session_token_into_collection(): void
    {
        $token = new SessionToken('some_token', new \DateTimeImmutable());
        $this->collection->expects(self::once())->method('updateOne')
            ->with(
                ['key' => 'some_key'],
                [
                    '$set' => [
                        'key' => 'some_key',
                        'authToken' => 'some_token',
                        'expireAt' => $this->dateTimeConverter->create($token->getExpiresAt())
                    ]
                ],
                ['upsert' => true]
            );

        $this->sut->save('some_key', $token);
    }


    /**
     * @test
     */
    public function it_sore_session_token_direct_into_in_memory_after_save(): void
    {
        $token = new SessionToken('some_token', new \DateTimeImmutable());
        $this->collection->expects(self::once())->method('updateOne');
        $this->collection->expects(self::never())->method('findOne');
        $this->sut->save('some_key', $token);
        self::assertSame($token, $this->sut->load('some_key'));
    }
}
