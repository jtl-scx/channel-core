<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-05-27
 */


namespace JTL\SCX\Lib\Channel\Core;

trait ToArrayTrait
{
    public function toArray(): array
    {
        return $this->createArray(get_object_vars($this));
    }

    protected function createArray(array $data): array
    {
        $return = [];
        foreach ($data as $key => $attr) {
            if (\is_object($attr)) {
                if ($attr instanceof \DateTimeImmutable) {
                    $return[$key] = $attr->format('c');
                } elseif (method_exists($attr, 'toArray')) {
                    $return[$key] = $attr->toArray();
                } else {
                    $return[$key] = $this->createArray((array)$attr);
                }
            } elseif (\is_array($attr)) {
                $data[$key] = $this->createArray($attr);
            } else {
                $return[$key] = $attr;
            }
        }
        return $return;
    }
}
