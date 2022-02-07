<?php
/**
 * ErrorTest
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
 * ErrorTest Class Doc Comment
 *
 * @category    Class
 * @description Error
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\Error
 */
class ErrorTest extends AbstractApiModelTest
{

    /**
     * Test allowed values for severity
     * @test
     */
    public function it_has_correct_allowed_values_for_severity(): void
    {
        $allowed = [
            'error','warning','info',
        ];

        $sut = new Error();
        $this->assertMethodExists($sut, 'getSeverityAllowableValues');
        $this->assertEquals($allowed, $sut->getSeverityAllowableValues());
    }
    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property Code' => [
                'code',
                'string',
                'getCode',
                'setCode',
                true
            ],
            'assert property Message' => [
                'message',
                'string',
                'getMessage',
                'setMessage',
                true
            ],
            'assert property Severity' => [
                'severity',
                'string',
                'getSeverity',
                'setSeverity',
                false
            ],
            'assert property Hint' => [
                'hint',
                'string',
                'getHint',
                'setHint',
                true
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(string $property, string $type, string $expectedGetter, string $expectedSetter, bool $isNullable): void
    {
        $sample = $this->buildSampleForDataType($type);
        $sut = new Error([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);

        if ($isNullable) {
            $sut = new Error([$property => null]);
            $this->assertNull($sut->$expectedGetter());

            $sut->$expectedSetter(null);
            $this->assertNull($sut->$expectedGetter());
        }
    }

}
