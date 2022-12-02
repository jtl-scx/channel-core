<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: marius
 * Date: 11/11/22
 */

namespace JTL\SCX\Lib\Channel\Core\Log\Context;

use JTL\SCX\Lib\Channel\Contract\Core\Log\ContextAware;

abstract class LabeledContextAware implements ContextAware
{
    /**
     * @return ContextLabel[]
     */
    abstract protected function getLabels(): array;
    abstract protected function getLogContext(): array;

    public function __invoke(array $record): array
    {
        $record['extra'] = array_merge($record['extra'] ?? [], $this->getLogContext());
        $record['extra']['label'] = $this->attachLabel($record['extra']['label'] ?? []);
        return $record;
    }

    private function attachLabel(array $labels): array
    {
        foreach ($this->getLabels() as $label) {
            $labels[] = $label->value;
        }

        return array_unique($labels);
    }
}
