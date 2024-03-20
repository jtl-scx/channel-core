<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: rherrgesell
 * Date: 2/10/20
 */

namespace JTL\SCX\Lib\Channel\Client\Attribute;

use JTL\SCX\Lib\Channel\Client\Model\ChannelAttribute;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Client\Attribute\AttributeSelector
 */
class AttributeSelectorTest extends TestCase
{
    public function testGetValueListById(): void
    {
        $testId = uniqid('testid');
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => $testId, 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => $testId, 'value' => 'baz'])
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueListById($testId, $list);

        $this->assertIsArray($result);
        $this->assertEquals(2, count($result));
        $this->assertEquals('bar', $result[0]);
        $this->assertEquals('baz', $result[1]);
    }

    public function testGetNullWhenAttributeNotExistsInList(): void
    {
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => 'bar', 'value' => 'bar']),
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueListById('gibesnichtid', $list);
        $this->assertNull($result);
    }

    public function testCanGetOneSingleValueById(): void
    {
        $testId = uniqid('testid');
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => $testId, 'value' => 'bar'])
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueById($testId, $list);

        $this->assertEquals('bar', $result);
    }

    public function testGetNullWhenAttributeNotExists(): void
    {
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => 'bar', 'value' => 'bar'])
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueById('igrendwaskomisches', $list);
        $this->assertNull($result);
    }

    public function testFirstAttributeIdIsSelected(): void
    {
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'first']),
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'second']),
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'third']),
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'forth']),
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueById('foo', $list);
        $this->assertEquals('first', $result);
        $this->assertNotEquals('second', $result);
    }

    /**
     * @test
     */
    public function it_can_fetch_a_boolean_value_from_AttributeList(): void
    {
        $list = [
            new ChannelAttribute(['attributeId' => '1', 'value' => 'true']),
            new ChannelAttribute(['attributeId' => '2', 'value' => 'false']),
            new ChannelAttribute(['attributeId' => '3', 'value' => 'yes']),
            new ChannelAttribute(['attributeId' => '4', 'value' => 'no']),
            new ChannelAttribute(['attributeId' => '5', 'value' => '1']),
            new ChannelAttribute(['attributeId' => '6', 'value' => '0']),
            new ChannelAttribute(['attributeId' => '7', 'value' => 'ja']),
            new ChannelAttribute(['attributeId' => '8', 'value' => 'nein']),
            new ChannelAttribute(['attributeId' => '9', 'value' => 'on']),
            new ChannelAttribute(['attributeId' => '10', 'value' => 'off']),
            new ChannelAttribute(['attributeId' => '100', 'value' => 'Natürlich']),
        ];
        $sut = new AttributeSelector();

        self::assertNull($sut->getBooleanById('not-in-list', $list, null));
        self::assertFalse($sut->getBooleanById('not-in-list', $list, false));
        self::assertTrue($sut->getBooleanById('not-in-list', $list, true));

        self::assertTrue($sut->getBooleanById('1', $list));
        self::assertTrue($sut->getBooleanById('3', $list));
        self::assertTrue($sut->getBooleanById('5', $list));
        self::assertTrue($sut->getBooleanById('7', $list));
        self::assertTrue($sut->getBooleanById('9', $list));

        self::assertFalse($sut->getBooleanById('2', $list));
        self::assertFalse($sut->getBooleanById('4', $list));
        self::assertFalse($sut->getBooleanById('6', $list));
        self::assertFalse($sut->getBooleanById('8', $list));
        self::assertFalse($sut->getBooleanById('10', $list));

        self::assertNull($sut->getBooleanById('Bier', $list));
        self::assertFalse($sut->getBooleanById('100', $list));
    }


}
