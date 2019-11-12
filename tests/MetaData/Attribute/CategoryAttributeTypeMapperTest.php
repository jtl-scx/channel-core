<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 11/12/19
 */

namespace MetaData\Attribute;

use JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeTypeMapper;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryAttributeTypeMapperTest
 * @package MetaData\Attribute
 *
 * @covers \JTL\SCX\Lib\Channel\MetaData\Attribute\CategoryAttributeTypeMapper
 */
class CategoryAttributeTypeMapperTest extends TestCase
{
    public function testCanMapType(): void
    {
        $mapper = new CategoryAttributeTypeMapper();

        $this->assertEquals('decimal', $mapper->map('Float'));
        $this->assertEquals('boolean', $mapper->map('Bool'));
        $this->assertEquals('integer', $mapper->map('Int'));
        $this->assertEquals('smalltext', $mapper->map('TinyText'));
        $this->assertEquals('smalltext', $mapper->map('Ean'));
        $this->assertEquals('date', $mapper->map('Date'));
        $this->assertEquals('text', $mapper->map('SmallText'));
        $this->assertEquals('text', $mapper->map('ShortText'));
        $this->assertEquals('text', $mapper->map('Text'));
        $this->assertEquals('text', $mapper->map('Picture'));
        $this->assertEquals('text', $mapper->map('Si_eurocent'));
        $this->assertEquals(null, $mapper->map(uniqid('garbage', true)));
    }
}
