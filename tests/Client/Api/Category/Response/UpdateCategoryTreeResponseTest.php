<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2019-10-30
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\CategoryTreeVersion;
use JTL\SCX\Client\Response\AbstractResponse;

/**
 * Class UpdateCategoryTreeResponseTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Category\Response
 */
#[CoversClass(\JTL\SCX\Lib\Channel\Client\Api\Category\Response\UpdateCategoryTreeResponse::class)]
class UpdateCategoryTreeResponseTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $response = new UpdateCategoryTreeResponse(200, $this->createStub(CategoryTreeVersion::class));

        $this->assertInstanceOf(UpdateCategoryTreeResponse::class, $response);
        $this->assertInstanceOf(AbstractResponse::class, $response);
    }

    public function testCanGetVersion(): void
    {
        $categoryTreeVersion = $this->createStub(CategoryTreeVersion::class);
        $response = new UpdateCategoryTreeResponse(200, $categoryTreeVersion);

        $this->assertSame($categoryTreeVersion, $response->getCategoryTreeVersion());
    }
}
