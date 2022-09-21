<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/15/21
 */

namespace JTL\SCX\Lib\Channel\Client\Api\Event\Response;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Api\Event\Response\AcknowledgeEventIdListResponse
 */
class AcknowledgeEventIdListResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_considered_successful_on_http_status_code_204(): void
    {
        $sut = new AcknowledgeEventIdListResponse(204);
        $this->assertTrue($sut->isSuccessful());
    }

    /**
     * @test
     */
    public function it_is_considered_failed_on_http_status_code_not_equals_204(): void
    {
        $sut = new AcknowledgeEventIdListResponse(200);
        $this->assertFalse($sut->isSuccessful());
    }
}
