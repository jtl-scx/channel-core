<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Core\Environment;

class Environment
{
    private array $env;

    public function __construct(array $env = null)
    {
        $this->env = $env ?? $_ENV;
    }

    public function get(string $name)
    {
        return $this->env[$name] ?? null;
    }

    public function isDevelopment(): bool
    {
        return $this->get('IS_DEVELOPMENT') === 'true';
    }

    public function getInt(string $name): ?int
    {
        return $this->get($name) !== null ? (int)$this->get($name) : null;
    }

    public function getString(string $name): ?string
    {
        return $this->get($name) !== null ? (string)$this->get($name) : null;
    }

    public function getBool(string $name): ?bool
    {
        return $this->get($name) !== null ? (bool)$this->get($name) : null;
    }

    public function exists(string $name): bool
    {
        return isset($this->env[$name]);
    }
}
