<?php
/**
 * AttributeTest
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  JTL\SCX\Lib\Channel\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * JTL-Channel API
 *
 * JTL-Channel API is a REST-based API that helps a Channel Integrator to connect Markeptlace with the JTL-Wawi  ERP System.  # Key Features  With the JTL-Channel API, you can:    * Describe connected Markeplace Data Structure by providing Category and Attribute Data   * Manage Product and Offer Listings   * Manage Orders    * Handle the Post Order Process  # Terminology  * ***Channel***: A Channel is a connection to a Marketplace or any external System which can be connected  to JTL-Channel API * ***Seller***: A Seller is a person - identified by a Id (sellerId) - who want to offer and sells his good  on the connected Channel. * ***Events***: A Event is a action initiated from a Seller. A Channel need to react on those Events in order  to create or update a Offer or to process some Post Orders actions. * ***Seller API***: This is the counter part for the Channel API. The ERP System JTL-Wawi is connected with the  Seller API.  # Seller Management  A Channel need do manage there Seller Accounts by itself. JTL will never be aware of any credentials  which are required by individual Seller to connect to certain Marketplace or externen System  (for example: API Credentials)  Each Channel must maintain a SignUpUrl and UpdateUrl. Those URLs pointing to a Login or Signup Page, hosted by the Channel itself. A Seller will create a SignUp or Update Session inside JTL-Wawi, which redirect the Seller together with a short lived and unique SessionId to the Channels hostes SignUp/Update URLs.  ## Seller Create  Seller Create a SignUp URL for Channel `MYCHANNEL using the Seller API ``` curl --location --request POST 'https://scx-sbx.api.jtl-software.com/v1/seller/channel/MYCHANNEL' \\ --header 'Authorization: Bearer eyJ01234567890dummy' ```  Response  ``` {   \"signUpUrl\": \"https://www.mychannel.com/?session=Ylc53NQr4bE2zaJOnMQ3JziabJMHVJCysodFiHZEfCYhVKh41cdQTJSD7BNfliys&expiresAt=1646759360\",   \"expiresAt\": 1646759360 } ```  Seller is redirect to the `signUpUrl`.   On the SignUp Page the Channel must ask for Seller identification. If a Seller is considered as valid and authenticated.  The Channel itself must create a unique SellerId and send them together with the sessionId, from the SignUp URL to  the Channel API.   ***Note***: All Events from the Channel API will have a SellerId. This sellerId is immutable and can not be changed  afterwards.  ``` curl --location --request POST 'https://scx-sbx.api.jtl-software.com/v1/channel/seller' \\ --header 'Authorization: Bearer eyJ01234567890dummy' \\ --header 'Content-Type: application/json' \\ --data-raw '{   \"session\": \"Ylc53NQr4bE2zaJOnMQ3JziabJMHVJCysodFiHZEfCYhVKh41cdQTJSD7BNfliys\",   \"sellerId\": \"1\",   \"companyName\": \"JTL-Software-GmbH\" }' ```  ## Seller Update  When a Sellers need to update their credentials they will use the create Update Session and redirected to the  Channel using the `updateUrl` property.   Seller update process in initiated by creating a Update URL for Channel `MYCHANNEL using the Seller API ``` curl --location --request PATCH 'https://scx-sbx.api.jtl-software.com/v1/seller/channel/MYCHANNEL?sellerId=1' \\ --header 'Authorization: Bearer eyJ01234567890dummy' ```  Response:  ``` {   \"updateUrl\": \"https://www.mychannel.com/update?session=xyz&expiresAt=1646759360\",   \"expiresAt\": 1646759360 } ```  The Seller is redirected to the Update Url from the Channel alongside with a short lived SessionId.   For security reason the sellerId is not part of the Update Url and must be received with a separate call.  ``` curl --location --request GET 'https://scx-sbx.api.jtl-software.com/v1/channel/seller/update-session?sessionId=xyz \\ --header 'Authorization: Bearer eyJ01234567890dummy ```  Response:  ``` {   \"sellerId\": \"1\" } ```  After the update workflow in handed the Channel may now update the seller at SCX-Channel-Api.  ``` {   \"sessionId\": \"xyz\",   \"isActive\": true   \"companyName\": \"JTL-Software-GmbH\" } ```
 *
 * The version of the OpenAPI document: 1.0.0
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.4.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the model.
 */

namespace JTL\SCX\Lib\Channel\Client\Model;

use JTL\SCX\Lib\Channel\Client\AbstractApiModelTest;

/**
 * AttributeTest Class Doc Comment
 *
 * @category    Class
 * @description Attribute
 * @package     JTL\SCX\Lib\Channel\Client
 * @author      OpenAPI Generator team
 * @link        https://openapi-generator.tech
 * @covers      \JTL\SCX\Lib\Channel\Client\Model\Attribute
 */
class AttributeTest extends AbstractApiModelTest
{

    /**
     * Test allowed values for type
     * @test
     */
    public function it_has_correct_allowed_values_for_type(): void
    {
        $allowed = [
            'smalltext','htmltext','text','integer','decimal','enum','date','boolean','image','document','url','label',
        ];

        $sut = new Attribute();
        $this->assertMethodExists($sut, 'getTypeAllowableValues');
        $this->assertEquals($allowed, $sut->getTypeAllowableValues());
    }
    /**
     * @return array
     * @dataProvider
     */
    public function expectedInterface(): array
    {
        return [
            'assert property AttributeId' => [
                'attributeId',
                'string',
                'getAttributeId',
                'setAttributeId',
                false
            ],
            'assert property DisplayName' => [
                'displayName',
                'string',
                'getDisplayName',
                'setDisplayName',
                false
            ],
            'assert property IsMultipleAllowed' => [
                'isMultipleAllowed',
                'bool',
                'getIsMultipleAllowed',
                'setIsMultipleAllowed',
                false
            ],
            'assert property Type' => [
                'type',
                'string',
                'getType',
                'setType',
                false
            ],
            'assert property Values' => [
                'values',
                '\JTL\SCX\Lib\Channel\Client\Model\AllowedValue[]',
                'getValues',
                'setValues',
                true
            ],
            'assert property AttributeValueValidation' => [
                'attributeValueValidation',
                'string',
                'getAttributeValueValidation',
                'setAttributeValueValidation',
                true
            ],
            'assert property ConditionalMandatoryBy' => [
                'conditionalMandatoryBy',
                '\JTL\SCX\Lib\Channel\Client\Model\AttributeConditionalMandatoryBy[]',
                'getConditionalMandatoryBy',
                'setConditionalMandatoryBy',
                true
            ],
            'assert property ConditionalOptionalBy' => [
                'conditionalOptionalBy',
                '\JTL\SCX\Lib\Channel\Client\Model\AttributeConditionalOptionalBy[]',
                'getConditionalOptionalBy',
                'setConditionalOptionalBy',
                true
            ],
            'assert property Required' => [
                'required',
                'bool',
                'getRequired',
                'setRequired',
                false
            ],
            'assert property Recommended' => [
                'recommended',
                'bool',
                'getRecommended',
                'setRecommended',
                false
            ],
            'assert property Section' => [
                'section',
                'string',
                'getSection',
                'setSection',
                true
            ],
            'assert property SectionPosition' => [
                'sectionPosition',
                'int',
                'getSectionPosition',
                'setSectionPosition',
                false
            ],
            'assert property IsRepeatableSubSection' => [
                'isRepeatableSubSection',
                'bool',
                'getIsRepeatableSubSection',
                'setIsRepeatableSubSection',
                false
            ],
            'assert property SubSection' => [
                'subSection',
                'string',
                'getSubSection',
                'setSubSection',
                true
            ],
            'assert property SubSectionPosition' => [
                'subSectionPosition',
                'int',
                'getSubSectionPosition',
                'setSubSectionPosition',
                false
            ],
            'assert property Description' => [
                'description',
                'string',
                'getDescription',
                'setDescription',
                true
            ],
            'assert property IsVariationDimension' => [
                'isVariationDimension',
                'bool',
                'getIsVariationDimension',
                'setIsVariationDimension',
                true
            ],
            'assert property EnumValues' => [
                'enumValues',
                'string[]',
                'getEnumValues',
                'setEnumValues',
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
        $sut = new Attribute([$property => $sample]);

        $this->assertMethodExists($sut, $expectedGetter);
        $this->assertSame($sample, $sut->$expectedGetter());

        $this->assertArrayHasKey($property, $sut);
        $this->assertSame($sample, $sut[$property]);

        $newSample = $this->buildSampleForDataType($type);
        $this->assertMethodExists($sut, $expectedSetter);
        $sut->$expectedSetter($newSample);
        $this->assertSame($newSample, $sut[$property]);

        if ($isNullable) {
            $sut = new Attribute([$property => null]);
            $this->assertNull($sut->$expectedGetter());

            $sut->$expectedSetter(null);
            $this->assertNull($sut->$expectedGetter());
        }
    }

}
