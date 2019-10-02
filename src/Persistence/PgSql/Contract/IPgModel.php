<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 10/2/19
 */

namespace JTL\SCX\Lib\Channel\Persistence\PgSql\Contract;

interface IPgModel
{
    /**
     * @return array
     */
    public function toArray(): array;
}
