<?php

namespace JTL\SCX\Lib\Channel\Core\Metrics;

use PHPUnit\Framework\Attributes\CoversClass;
use JTL\OpsGenie\Client\AlertApiClient;
use JTL\OpsGenie\Client\HeartbeatApiClient;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Metrics\OpsGenieFactory::class)]
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
        self::assertInstanceOf(AlertApiClient::class, $this->sut->createAlertClient());
    }

    public function testCanCreateHeartbeatClient(): void
    {
        $this->env->expects(self::once())->method('get')->with('OPSGENIE_TOKEN')->willReturn(uniqid());
        self::assertInstanceOf(HeartbeatApiClient::class, $this->sut->createHeartbeatClient());
    }
}
