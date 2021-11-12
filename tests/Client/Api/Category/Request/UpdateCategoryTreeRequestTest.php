<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/23
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Category\Request;

use PHPUnit\Framework\TestCase;
use JTL\SCX\Lib\Channel\Client\Model\ChannelCategoryTree;

/**
 * Class UpdateCategoryTreeRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api\Category\Request
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Category\Request\UpdateCategoryTreeRequest
 */
class UpdateCategoryTreeRequestTest extends TestCase
{
    public function testCanBeCreatedAndUsed(): void
    {
        $bodyStr = uniqid('body', true);
        $channelCategoryTree = $this->createMock(ChannelCategoryTree::class);
        $channelCategoryTree->expects($this->once())->method('__toString')->willReturn($bodyStr);

        $request = new UpdateCategoryTreeRequest($channelCategoryTree);

        $this->assertSame($channelCategoryTree, $request->getChannelCategoryTree());
        $this->assertSame($bodyStr, $request->getBody());
        $this->assertSame('PUT', $request->getHttpMethod());
        $this->assertSame('/v1/channel/categories', $request->getUrl());
    }
}
