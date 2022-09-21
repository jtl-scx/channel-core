<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/12/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Order\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Order\Response\DenyCancellationResponse
 */
class DenyCancellationResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_consider_request_as_successful_on_http_code_201(): void
    {
        $sut = new DenyCancellationResponse(201);
        $this->assertTrue($sut->isSuccessful());
    }
}
