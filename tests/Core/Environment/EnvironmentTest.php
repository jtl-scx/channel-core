<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 7/23/20
 */

namespace JTL\SCX\Lib\Channel\Core\Environment;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use PHPUnit\Framework\TestCase;

#[CoversClass(\JTL\SCX\Lib\Channel\Core\Environment\Environment::class)]
class EnvironmentTest extends TestCase
{
    public function tearDown(): void
    {
        $_ENV = [];
    }

    #[Test]
    public function it_will_handle_environment_variables_as_immutable_list()
    {
        $_ENV['foo'] = 'should-not-change';
        $env = new Environment();

        $_ENV['foo'] = 'it-change';
        $this->assertEquals('should-not-change', $env->get('foo'));
    }

    #[Test]
    public function it_can_build_with_a_own_set_of_environment_variables()
    {
        $env = new Environment(['any-env' => 'any-value']);
        $this->assertEquals('any-value', $env->get('any-env'));
    }

    #[Test]
    public function it_will_ignore_ENV_superglobals_when_using_a_own_set_of_environment_variables()
    {
        $_ENV['any-env'] = 'with-any-value';
        $env = new Environment(['any-env' => 'any-value']);
        $this->assertEquals('any-value', $env->get('any-env'));
    }

    #[Test]
    public function it_can_read_existing_key()
    {
        $_ENV['foo'] = 'bar';
        $env = new Environment();
        $this->assertEquals($_ENV['foo'], $env->get('foo'));
    }

    #[Test]
    public function it_can_return_null_when_key_not_exists()
    {
        $env = new Environment();
        $this->assertNull($env->get('should-no-exists'));
    }

    #[Test]
    public function it_can_check_if_current_environment_is_considered_as_development()
    {
        $_ENV['IS_DEVELOPMENT'] = 'true';
        $env = new Environment();
        $this->assertTrue($env->isDevelopment());
    }

    #[Test]
    public function it_can_check_a_environment_variable_exists()
    {
        $_ENV['should-exist'] = 'yeah!';
        $env = new Environment();
        $this->assertTrue($env->exists('should-exist'));
    }

    #[Test]
    public function it_can_read_environment_value_as_integer()
    {
        $_ENV['it-is-an-int'] = '1337';
        $env = new Environment();
        $this->assertIsInt($env->getInt('it-is-an-int'));
    }

    #[Test]
    public function it_can_read_environment_value_as_string()
    {
        $_ENV['it-is-an-string'] = '1337';
        $env = new Environment();
        $this->assertIsString($env->getString('it-is-an-string'));
    }

    #[Test]
    public function it_can_read_environment_value_as_boolean()
    {
        $_ENV['it-is-an-boolean'] = '1';
        $env = new Environment();
        $this->assertIsBool($env->getBool('it-is-an-boolean'));
    }
}
