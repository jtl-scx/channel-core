<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 */

namespace JTL\SCX\Lib\Channel\Helper\Command;

use JTL\SCX\Lib\Channel\Contract\Core\Message\CliConstructable;

class CliConstructableTestMessage implements CliConstructable
{
    /**
     * @param string[] $items
     */
    private function __construct(public readonly string $sellerId, public readonly array $items)
    {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function createFrom(array $payload = []): static
    {
        $items = [];
        foreach (is_array($payload['items'] ?? null) ? $payload['items'] : [] as $item) {
            $items[] = (string)$item;
        }

        return new static((string)($payload['sellerId'] ?? ''), $items);
    }
}
