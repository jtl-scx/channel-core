<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 1/16/20
 */

namespace JTL\SCX\Lib\Channel\Database\Migration;

use ReflectionClass;


#[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
class CollectionSchemaLoader
{
    /**
     * @param string $migrationPath
     * @return array
     * @throws \ReflectionException
     */
    #[\Deprecated(message: "Will be removed with 1.3.0", since: "1.2.1")]
    public function getCollectionSchemaList(string $migrationPath): array
    {
        $this->loadPhpFiles($migrationPath);

        $classes = get_declared_classes();
        $migrationClasses = [];
        foreach ($classes as $class) {
            $reflect = new ReflectionClass($class);
            if ($reflect->implementsInterface(CollectionSchema::class) && !$reflect->isAbstract()) {
                $migrationClasses[] = new $class();
            }
        }

        return $migrationClasses;
    }

    private function loadPhpFiles(string $migrationPath)
    {
        $pattern = $migrationPath . '/*.php';
        $files = glob($pattern);

        if ($files === false) {
            return;
        }

        foreach ($files as $file) {
            include_once $file;
        }
    }
}
