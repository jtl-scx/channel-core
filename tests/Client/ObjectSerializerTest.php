<?php

declare(strict_types=1);

namespace JTL\SCX\Lib\Channel\Client;

use JTL\SCX\Lib\Channel\Client\Model\Attribute;
use PHPUnit\Framework\TestCase;

/**
 * Class ObjectSerializerTest
 * @package JTL\SCX\Lib\Channel\Client
 *
 * @covers \JTL\SCX\Lib\Channel\Client\ObjectSerializer
 */
class ObjectSerializerTest extends TestCase
{
    /**
     * Regression test: sanitizeForSerialization()'s return type union used to be
     * `object|array|null|string`, missing bool/int/float. Without strict_types, PHP
     * weak-coerces a returned scalar into whatever the union does allow, silently
     * turning `false` into `""` and `0` into `"0"` on the way out to json_encode().
     */
    public function testSanitizeForSerializationPreservesScalarTypes(): void
    {
        $this->assertSame(false, ObjectSerializer::sanitizeForSerialization(false));
        $this->assertSame(true, ObjectSerializer::sanitizeForSerialization(true));
        $this->assertSame(0, ObjectSerializer::sanitizeForSerialization(0));
        $this->assertSame(1.5, ObjectSerializer::sanitizeForSerialization(1.5));
        $this->assertSame('x', ObjectSerializer::sanitizeForSerialization('x'));
        $this->assertNull(ObjectSerializer::sanitizeForSerialization(null));
    }

    public function testModelJsonEncodesBoolAndIntPropertiesAsRealJsonTypes(): void
    {
        $attribute = new Attribute([
            'attributeId' => 'x',
            'displayName' => 'y',
            'isMultipleAllowed' => false,
            'required' => false,
            'recommended' => false,
            'sectionPosition' => 0,
        ]);

        $decoded = json_decode(json_encode($attribute), true);

        $this->assertFalse($decoded['isMultipleAllowed']);
        $this->assertFalse($decoded['required']);
        $this->assertFalse($decoded['recommended']);
        $this->assertSame(0, $decoded['sectionPosition']);
    }
}
