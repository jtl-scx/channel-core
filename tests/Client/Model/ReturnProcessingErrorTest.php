<?php
/**
 * ReturnProcessingErrorTest
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
 * ReturnProcessingErrorTest Class Doc Comment
 *
 * @category    Class
 * @description ReturnProcessingError
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\ReturnProcessingError
 */
class ReturnProcessingErrorTest extends AbstractApiModelTest
{
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
                'setCode'
            ],
            'assert property Message' => [
                'message',
                'string',
                'getMessage',
                'setMessage'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(string $property, string $type, string $expectedGetter, string $expectedSetter): void
    {
        $sample = $this->buildSampleForDataType($type);
        $sut = new ReturnProcessingError([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);
    }
}
