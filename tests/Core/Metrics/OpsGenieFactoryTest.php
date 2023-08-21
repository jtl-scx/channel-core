<?php

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \JTL\SCX\Lib\Channel\Core\Metrics\OpsGenieFactory
 */
class OpsGenieFactoryTest extends TestCase
{
    private Environment|MockObject $env;
    private OpsGenieFactory $sut;

    public function setUp(): void
    {
        $this->env = $this->createMock(Environment::class);
        $this->sut = new OpsGenieFactory($this->env);
    }

    public function testCanCreateAlertClient(): void
    {
        $this->env->expects(self::once())->method('get')->with('OPSGENIE_TOKEN')->willReturn(uniqid());
        self::assertInstanceOf(\JTL\OpsGenie\Client\AlertApiClient::class, $this->sut->createAlertClient());
    }

    public function testCanCreateHeartbeatClient(): void
    {
        $this->env->expects(self::once())->method('get')->with('OPSGENIE_TOKEN')->willReturn(uniqid());
        self::assertInstanceOf(\JTL\OpsGenie\Client\HeartbeatApiClient::class, $this->sut->createHeartbeatClient());
    }
}
