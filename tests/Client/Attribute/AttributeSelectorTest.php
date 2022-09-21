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
    public function testGetValueListById()
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

    public function testGetNullWhenAttributeNotExistsInList()
    {
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => 'bar', 'value' => 'bar']),
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueListById('gibesnichtid', $list);
        $this->assertNull($result);
    }

    public function testCanGetOneSingleValueById()
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

    public function testGetNullWhenAttributeNotExists()
    {
        $list = [
            new ChannelAttribute(['attributeId' => 'foo', 'value' => 'bar']),
            new ChannelAttribute(['attributeId' => 'bar', 'value' => 'bar'])
        ];
        $selector = new AttributeSelector();

        $result = $selector->getValueById('igrendwaskomisches', $list);
        $this->assertNull($result);
    }

    public function testFirstAttributeIdIsSelected()
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
}
