<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Contract\Core\Message;

interface CliConstructable
{
    /**
     * @param array<string, mixed> $payload
     */
    public static function createFrom(array $payload = []): static;
}
