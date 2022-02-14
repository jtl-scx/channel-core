<?php
/**
 * SalesChannelDataTest
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
 * SalesChannelDataTest Class Doc Comment
 *
 * @category    Class
 * @description SalesChannelData
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\SalesChannelData
 */
class SalesChannelDataTest extends AbstractApiModelTest
{


    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property Channel' => [
                'channel',
                'string',
                'getChannel',
                'setChannel'
            ],
            'assert property Currency' => [
                'currency',
                'string',
                'getCurrency',
                'setCurrency'
            ],
            'assert property MarketplaceList' => [
                'marketplaceList',
                'string[]',
                'getMarketplaceList',
                'setMarketplaceList'
            ],
            'assert property SupportedLanguages' => [
                'supportedLanguages',
                'string[]',
                'getSupportedLanguages',
                'setSupportedLanguages'
            ],
            'assert property DisplayName' => [
                'displayName',
                'string',
                'getDisplayName',
                'setDisplayName'
            ],
            'assert property Website' => [
                'website',
                'string',
                'getWebsite',
                'setWebsite'
            ],
            'assert property SupportContact' => [
                'supportContact',
                'string',
                'getSupportContact',
                'setSupportContact'
            ],
            'assert property Vendor' => [
                'vendor',
                'string',
                'getVendor',
                'setVendor'
            ],
            'assert property SignUpUrl' => [
                'signUpUrl',
                'string',
                'getSignUpUrl',
                'setSignUpUrl'
            ],
            'assert property FeatureList' => [
                'featureList',
                '\JTL\SCX\Lib\Channel\Client\Model\ChannelUpdateFeatureList',
                'getFeatureList',
                'setFeatureList'
            ],
            'assert property UpdateUrl' => [
                'updateUrl',
                'string',
                'getUpdateUrl',
                'setUpdateUrl'
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
        $sut = new SalesChannelData([$property => $sample]);

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
