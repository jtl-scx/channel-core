<?php
/**
 * AddressTest
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
 * AddressTest Class Doc Comment
 *
 * @category    Class
 * @description Address
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\Address
 */
class AddressTest extends AbstractApiModelTest
{

    /**
     * Test allowed values for gender
     * @test
     */
    public function it_has_correct_allowed_values_for_gender(): void
    {
        $allowed = [
            'male','female','diverse',
        ];

        $sut = new Address();
        $this->assertMethodExists($sut, 'getGenderAllowableValues');
        $this->assertEquals($allowed, $sut->getGenderAllowableValues());
    }
    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property FirstName' => [
                'firstName',
                'string',
                'getFirstName',
                'setFirstName',
                true
            ],
            'assert property LastName' => [
                'lastName',
                'string',
                'getLastName',
                'setLastName',
                false
            ],
            'assert property Gender' => [
                'gender',
                'string',
                'getGender',
                'setGender',
                true
            ],
            'assert property CompanyName' => [
                'companyName',
                'string',
                'getCompanyName',
                'setCompanyName',
                true
            ],
            'assert property Street' => [
                'street',
                'string',
                'getStreet',
                'setStreet',
                false
            ],
            'assert property HouseNumber' => [
                'houseNumber',
                'string',
                'getHouseNumber',
                'setHouseNumber',
                true
            ],
            'assert property Addition' => [
                'addition',
                'string',
                'getAddition',
                'setAddition',
                true
            ],
            'assert property Postcode' => [
                'postcode',
                'string',
                'getPostcode',
                'setPostcode',
                true
            ],
            'assert property City' => [
                'city',
                'string',
                'getCity',
                'setCity',
                false
            ],
            'assert property Phone' => [
                'phone',
                'string',
                'getPhone',
                'setPhone',
                true
            ],
            'assert property Country' => [
                'country',
                'string',
                'getCountry',
                'setCountry',
                false
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
        $sut = new Address([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);

        if ($isNullable) {
            $sut = new Address([$property => null]);
            $this->assertNull($sut->$expectedGetter());

            $sut->$expectedSetter(null);
            $this->assertNull($sut->$expectedGetter());
        }
    }

}
