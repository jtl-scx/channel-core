<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client\Model;

use JTL\SCX\Lib\Channel\Client\ObjectSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ObjectSerializer::class)]
class ModelStaticArraysTest extends TestCase
{
    private const SCALAR_SAMPLES = [
        'string' => 'sample',
        'int' => 7,
        'integer' => 7,
        'float' => 1.5,
        'double' => 1.5,
        'bool' => true,
        'boolean' => true,
    ];

    /**
     * @return array<string, array{class-string<ModelInterface>}>
     */
    public static function modelClasses(): array
    {
        $classes = [];
        foreach (glob(__DIR__ . '/../../../src/Client/Model/*.php') as $file) {
            $class = __NAMESPACE__ . '\\' . basename($file, '.php');
            if (is_subclass_of($class, ModelInterface::class) && !(new \ReflectionClass($class))->isAbstract()) {
                $classes[basename($file, '.php')] = [$class];
            }
        }

        return $classes;
    }

    /**
     * @param class-string<ModelInterface> $class
     */
    #[DataProvider('modelClasses')]
    #[Test]
    public function it_declares_every_property_in_all_five_static_arrays(string $class): void
    {
        $expected = array_keys($class::openAPITypes());
        sort($expected);

        foreach (['openAPIFormats', 'attributeMap', 'setters', 'getters'] as $array) {
            $actual = array_keys($class::$array());
            sort($actual);
            self::assertSame($expected, $actual, "$class::\$$array has other properties than openAPITypes()");
        }
    }

    /**
     * @param class-string<ModelInterface> $class
     */
    #[DataProvider('modelClasses')]
    #[Test]
    public function it_names_only_existing_accessor_methods(string $class): void
    {
        $missing = [];
        foreach ([...array_values($class::setters()), ...array_values($class::getters())] as $method) {
            if (!method_exists($class, $method)) {
                $missing[] = $method;
            }
        }

        self::assertSame([], $missing);
    }

    /**
     * @return array<string, array{class-string<ModelInterface>}>
     */
    public static function modelClassesWithScalarProperties(): array
    {
        return array_filter(
            self::modelClasses(),
            static fn (array $case): bool => self::scalarProperties($case[0]) !== []
        );
    }

    /**
     * @param class-string<ModelInterface> $class
     */
    #[DataProvider('modelClassesWithScalarProperties')]
    #[Test]
    public function it_reads_every_scalar_property_from_its_json_name(string $class): void
    {
        $json = [];
        foreach (self::scalarProperties($class) as $property => $type) {
            $json[$class::attributeMap()[$property]] = self::SCALAR_SAMPLES[$type];
        }

        $result = ObjectSerializer::deserialize(json_encode($json, JSON_THROW_ON_ERROR), $class);

        $actual = [];
        foreach (self::scalarProperties($class) as $property => $type) {
            $actual[$class::attributeMap()[$property]] = $result->{$class::getters()[$property]}();
        }
        self::assertSame($json, $actual);
    }

    /**
     * @param class-string<ModelInterface> $class
     * @return array<string, string>
     */
    private static function scalarProperties(string $class): array
    {
        return array_filter(
            $class::openAPITypes(),
            static fn (string $type, string $property): bool => array_key_exists($type, self::SCALAR_SAMPLES)
                && $class::openAPIFormats()[$property] === null,
            ARRAY_FILTER_USE_BOTH
        );
    }
}
