<?php
/**
 * ChannelNotificationSeverityTest
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * SCX Channel API
 *
 * SCX Channel API
 *
 * The version of the OpenAPI document: 1.0.0
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.1.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the model.
 */

namespace JTL\SCX\Lib\Channel\Client\Model;

use JTL\SCX\Lib\Channel\Client\AbstractApiModelTest;

/**
 * ChannelNotificationSeverityTest Class Doc Comment
 *
 * @category    Class
 * @description ChannelNotificationSeverity
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\ChannelNotificationSeverity
 */
class ChannelNotificationSeverityTest extends AbstractApiModelTest
{

    /**
     * Test Enum Value "INFO"
     * @test
     */
    public function is_a_const_INFO(): void
    {
        self::assertEquals('INFO', ChannelNotificationSeverity::INFO);
        $sut = new ChannelNotificationSeverity('INFO');
        self::assertEquals('INFO', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "INFO"
     * @test
     */
    public function it_can_be_constructed_forINFO(): void
    {
        $sut = ChannelNotificationSeverity::INFO();
        self::assertInstanceOf(ChannelNotificationSeverity::class, $sut);
    }
    /**
     * Test Enum Value "WARNING"
     * @test
     */
    public function is_a_const_WARNING(): void
    {
        self::assertEquals('WARNING', ChannelNotificationSeverity::WARNING);
        $sut = new ChannelNotificationSeverity('WARNING');
        self::assertEquals('WARNING', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "WARNING"
     * @test
     */
    public function it_can_be_constructed_forWARNING(): void
    {
        $sut = ChannelNotificationSeverity::WARNING();
        self::assertInstanceOf(ChannelNotificationSeverity::class, $sut);
    }
    /**
     * Test Enum Value "ERROR"
     * @test
     */
    public function is_a_const_ERROR(): void
    {
        self::assertEquals('ERROR', ChannelNotificationSeverity::ERROR);
        $sut = new ChannelNotificationSeverity('ERROR');
        self::assertEquals('ERROR', $sut->getValue());
    }

    /**
     * Test Enum Value Named Constructor "ERROR"
     * @test
     */
    public function it_can_be_constructed_forERROR(): void
    {
        $sut = ChannelNotificationSeverity::ERROR();
        self::assertInstanceOf(ChannelNotificationSeverity::class, $sut);
    }

    /**
     * Test allowed values from Enum
     * @test
     */
    public function it_has_correct_set_of_allowed_values(): void
    {
        $allowed = [
            ChannelNotificationSeverity::INFO,
            ChannelNotificationSeverity::WARNING,
            ChannelNotificationSeverity::ERROR,
        ];
        self::assertEquals($allowed, ChannelNotificationSeverity::getAllowableEnumValues());
    }
}
