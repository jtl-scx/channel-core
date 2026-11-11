# channel-core

PHP library with the shared code of the SCX channel integrations. This file is the rule set for
writing the Channel API models in `src/Client/Model/` by hand.

## Source of truth

The Channel API spec is `spec/api/api_channel.openapi.yaml` in `scx-api`. Nothing generates code
from it. A model is written by hand and follows the spec.

A schema usually sits in a split file in `spec/api/spec/` that the main spec reaches by `$ref`.
The seller and admin specs use these files too. Search that folder for the schema name.

[MUST] change the spec in `scx-api` first. Then change the model here.
[MUST NOT] add a property, a type or an allowed value here that the spec does not have.

## Commands

The CI runs these checks (`.github/workflows/ci.yml`):

```bash
composer install
composer phpstan
composer phpcs-dry
vendor/bin/phpunit
```

Fix style with `composer phpcs`.

## Models

- Namespace `JTL\SCX\Lib\Channel\Client\Model`. One class per file in `src/Client/Model/`.
- The class name is the schema name in the spec. The file name is the class name. Two cases have
  no schema name, see [allOf and inline objects](#allof-and-inline-objects).
- A model does not declare `strict_types`, like the existing ones. With `strict_types`,
  `mb_strlen(null)` on a required property that is not set throws a `TypeError`, so `valid()`
  throws instead of returning `false`. `WorkEventCommand` calls `valid()` at runtime.
- A model implements `ModelInterface`, `ArrayAccess` and `\JsonSerializable`.
- Copy the structure of an existing model. `AllowedValue.php` is a small example, `Attribute.php`
  has an enum property and lists of models.
- Every property has an entry in each of these static arrays, in the same order as the spec:
  `$openAPITypes`, `$openAPIFormats`, `$attributeMap`, `$setters` and `$getters`. Keep the
  accessor methods (`openAPITypes()`, `openAPIFormats()`, `attributeMap()`, `setters()`,
  `getters()`, `getModelName()`) and `DISCRIMINATOR`, `$openAPIModelName` and `$container`.
- A type is a PHP scalar (`string`, `int`, `float`, `bool`), a `\DateTime`, a fully qualified
  model class, or one of these with `[]` for a list, for example
  `\JTL\SCX\Lib\Channel\Client\Model\AllowedValue[]`. Put the spec `format` in `$openAPIFormats`,
  or `null`. More cases:
  - A binary file (`format: binary`) has the type `\SplFileObject` and the format `binary`
    (`InvoiceUpload.php`, property `document`).
  - A `$ref` to an enum schema has the enum class as type (`Order.php`, property `orderStatus`).
  - A `oneOf` has a type that is not a class. Copy the type string of an existing `oneOf`
    (`SellerEventListEventList.php`, property `event`).
  - Key and value in `$attributeMap` can differ. Copy the spec name exactly
    (`ReportRequestOptions.php`, `'resultsAsChannelEvent' => 'ResultsAsChannelEvent'`).
- The constructor reads each property with `$data['name'] ?? null`. Use the spec default instead
  of `null` when the spec has one.
- A required property has a non-nullable getter and setter type. An optional property has a
  nullable type (`?string`). The setter returns `$this` and its return type is the class.
- A list property has the getter and setter type `?array` (or `array` when required). The
  `Model[]` type goes in `$openAPITypes` only.
- The model keeps its values in `$container` only. Do not add other state.
- A model that is not a seller event needs no registration. `ObjectSerializer` reads
  `$openAPITypes`.
- A seller event model is also wired in four places. Without them the channel gets the event as
  `Unknown`:
  - `EventType::getEventModelClass()` in `src/Client/Event/EventType.php`
  - `src/Event/EventFactory.php`
  - `src/Client/Api/Event/Model/EventContainer.php`
  - one event class in `src/Event/Seller/`
- Do not add business logic. A model holds data and validates it.

### allOf and inline objects

- `allOf` becomes one flat class. It has the properties and the required lists of all parts, in
  `allOf` order. [MUST NOT] use `extends` and [MUST NOT] write a class for a part. The nine parts
  that have no class on purpose are `ReportIdRelated`, `EventSellerRelated`, `SalesChannelOffer`,
  `Product`, `OfferIdRelated`, `SalesChannelBase`, `ReportRequest`, `ReportSellerInventory` and
  `TicketReply`.
- An inline object has no name in the spec. Its class name is the name of the parent schema plus
  the property name in PascalCase, and `Inner` at the end when it is the item of a list. Examples:
  `AttributeConditionalMandatoryByInner`, `OrderStatusOrderItemsInner`,
  `SellerEventListEventList`. [MUST NOT] invent another form.

### Validation

Validation lives in `listInvalidProperties()`. `valid()` returns `count(listInvalidProperties()) === 0`.

For every constraint in the spec, add a check with a message that says what is wrong:

- Required property: `'name' can't be null`.
- `minLength` and `maxLength`: `mb_strlen()`.
- `pattern`: `preg_match()`. The spec stores the pattern without delimiters
  (`'^\w{1,50}$'`). Wrap it in `/.../`, escape each `/` inside it and double the backslashes in
  the double-quoted string: `"/^\\w{1,50}$/"`. Without the delimiters PHP warns and returns
  `false`, so `valid()` rejects every value. Copy `AttachmentData.php` (`sellerId`).
- `minimum` and `maximum`: a comparison.
- `minItems`: `is_countable()` and `count()`. Never compare the array itself with a number. Copy the
  form and the message from `OfferListingFailed.php` (`errorList`):
  `if (!is_null($this->container['x']) && (is_countable($this->container['x']) && count($this->container['x']) < 1))`
  with the message `invalid value for 'x', number of items must be greater than or equal to 1.`
- `maxItems`: [MUST NOT] write a check (EA-8533). The upstream API enforces the limits. Only two
  checks stay: `channelSpecificAttributeList` in `ShippingRules` and `SellerShippingRules`.
- Optional property: guard every check with `!is_null($this->container['name'])`.
- Allowed values: a `public const` for each value, a `get<Name>AllowableValues()` method, and an
  `in_array(..., true)` check.

Copy the message texts from an existing model, so reviews stay simple.

## Enums

An enum schema is a class that implements `EnumInterface`. Copy `OrderItemPaymentStatus.php`:

- a `public const` for each value
- `getAllowableEnumValues()`
- a static factory for each value, named like the value
- a constructor that takes the value, and `getValue()`

## Tests

Every model has a test in `tests/Client/Model/<Name>Test.php`.

- The test extends `AbstractApiModelTestCase` and has `#[CoversClass(<Name>::class)]`.
- `expectedInterface()` lists every property with its name, type, getter, setter and a flag for
  nullable. `it_has_expected_interface` is the test that uses it. Copy `AllowedValueTest.php`.
- Add a test for each validation rule you add. Name it by the behaviour, in snake_case.
- The flag is `true` when the property keeps `null` after a round trip, and `false` when it does
  not. A property with a non-null default is `false`, because the constructor replaces `null` with
  the default. `AllowedValue::getSort()` returns `?int`, yet `sort` is `false` in
  `AllowedValueTest.php`. Do not take the flag from the PHP type.
- A binary property (`\SplFileObject`) needs the type `\SplFileObject` in `expectedInterface()`
  (`InvoiceUploadTest.php`).
- Every enum has a test. Copy `OrderItemPaymentStatusTest.php`: `is_a_const_<VALUE>` and
  `it_can_be_constructed_for<VALUE>` for each value, and `it_has_correct_set_of_allowed_values`.
- A model with an inline enum has `it_has_correct_allowed_values_for_<property>`
  (`AttributeTest.php`).

## Checklist for a new model

1. The schema exists in the spec in `scx-api`.
2. The class has the spec name, in `src/Client/Model/<Name>.php`.
3. Every property is in all five static arrays and has a getter and a setter.
4. Required and optional types match the spec.
5. Every spec constraint has a check in `listInvalidProperties()`.
6. The test exists and lists every property.
7. PHPUnit, phpstan and php-cs-fixer pass (see [Commands](#commands)).

## Old files

Most models and tests still carry the header "auto generated by OpenAPI Generator". That is
history. [MUST NOT] copy the header into a new file. [SHOULD] replace it in a file you change for
another reason.
