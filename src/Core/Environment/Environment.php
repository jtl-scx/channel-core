<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/30
 */

namespace JTL\SCX\Lib\Channel\Core\Environment;

use RuntimeException;

class Environment
{
    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        $result = getenv($key);

        if ($result === false) {
            throw new RuntimeException('Could not get environment variable ' . $key);
        }

        return $result;
    }
}
