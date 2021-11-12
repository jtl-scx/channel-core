<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-01-13
 */

namespace JTL\SCX\Lib\Channel\Client\Api;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractScxApiRequestTest
 * @package JTL\SCX\Lib\Channel\Client\Api
 *
 * @covers \JTL\SCX\Lib\Channel\Client\Api\AbstractScxApiRequest
 */
class AbstractScxApiRequestTest extends TestCase
{
    public function testHasDefaults(): void
    {
        $request = new TestRequest();
        $this->assertSame('application/json', $request->getContentType());
        $this->assertSame([], $request->getAdditionalHeaders());
        $this->assertSame([], $request->getParams());
        $this->assertSame('', $request->getBody());
    }
}

class TestRequest extends AbstractScxApiRequest
{
    public function getUrl(): string
    {
        return '';
    }

    public function getHttpMethod(): string
    {
        return '';
    }
}
