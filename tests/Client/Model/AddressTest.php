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
use JTL\SCX\Lib\Channel\Client\ObjectSerializer;

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
            'male',
            'female',
            'diverse',
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
                'setFirstName'
            ],
            'assert property LastName' => [
                'lastName',
                'string',
                'getLastName',
                'setLastName'
            ],
            'assert property Gender' => [
                'gender',
                'string',
                'getGender',
                'setGender'
            ],
            'assert property CompanyName' => [
                'companyName',
                'string',
                'getCompanyName',
                'setCompanyName'
            ],
            'assert property Street' => [
                'street',
                'string',
                'getStreet',
                'setStreet'
            ],
            'assert property HouseNumber' => [
                'houseNumber',
                'string',
                'getHouseNumber',
                'setHouseNumber'
            ],
            'assert property Addition' => [
                'addition',
                'string',
                'getAddition',
                'setAddition'
            ],
            'assert property Postcode' => [
                'postcode',
                'string',
                'getPostcode',
                'setPostcode'
            ],
            'assert property City' => [
                'city',
                'string',
                'getCity',
                'setCity'
            ],
            'assert property Phone' => [
                'phone',
                'string',
                'getPhone',
                'setPhone'
            ],
            'assert property Country' => [
                'country',
                'string',
                'getCountry',
                'setCountry'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider expectedInterface
     */
    public function it_has_expected_interface(
        string $property,
        string $type,
        string $expectedGetter,
        string $expectedSetter
    ): void {
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
    }

    /**
     * @test
     */
    public function it_can_be_serialized_and_deserialized(): void
    {
        $sut = new Address([
            "lastName" => 'foo',
            "street" => 'A_STREET',
            'city' => 'A_CITY',
            'country' => 'A_COUNTRY'
        ]);

        $expectedJson = <<<JSON
{
    "lastName": "foo",
    "street": "A_STREET",
    "city": "A_CITY",
    "country": "A_COUNTRY"
}
JSON;

        self::assertEquals($expectedJson, $sut->__toString());
        self::assertEquals($sut, ObjectSerializer::deserialize($sut->__toString(), $sut::class));
    }
}
