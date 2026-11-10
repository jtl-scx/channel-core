# channel-core

PHP library with the shared code of the SCX channel integrations. This file is the rule set for
writing the Channel API models in `src/Client/Model/` by hand.

## Source of truth

The Channel API spec is `api_channel.openapi.yaml` in the `spec/` folder of `scx-api`. Nothing
generates code from it. A model is written by hand and follows the spec.

A schema usually sits in a split file that the main spec reaches by `$ref`. Search the spec folder
for the schema name.

[MUST] change the spec in `scx-api` first. Then change the model here.
[MUST NOT] add a property, a type or an allowed value here that the spec does not have.

## Commands

Run from the dev environment folder `env/` of the workbench:

```bash
podman compose --profile core up -d channel-core
podman compose exec channel-core php vendor/bin/phpunit --no-coverage
podman compose exec channel-core composer phpstan
podman compose exec channel-core vendor/bin/php-cs-fixer fix --dry-run
```

Fix style with `composer phpcs`. The CI runs the same checks (`.github/workflows/ci.yml`).

## Models

- Namespace `JTL\SCX\Lib\Channel\Client\Model`. One class per file in `src/Client/Model/`.
- The class name is the schema name in the spec. The file name is the class name.
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
  or `null`.
- The constructor reads each property with `$data['name'] ?? null`. Use the spec default instead
  of `null` when the spec has one.
- A required property has a non-nullable getter and setter type. An optional property has a
  nullable type (`?string`). The setter returns `$this` and its return type is the class.
- A list property has the getter and setter type `?array` (or `array` when required). The
  `Model[]` type goes in `$openAPITypes` only.
- The model keeps its values in `$container` only. Do not add other state.
- A new model needs no registration anywhere. `ObjectSerializer` reads `$openAPITypes`.
- Do not add business logic. A model holds data and validates it.

### Validation

Validation lives in `listInvalidProperties()`. `valid()` returns `count(listInvalidProperties()) === 0`.

For every constraint in the spec, add a check with a message that says what is wrong:

- Required property: `'name' can't be null`.
- `minLength` and `maxLength`: `mb_strlen()`.
- `pattern`: `preg_match()` with the spec pattern.
- `minimum` and `maximum`: a comparison.
- `minItems` and `maxItems`: `is_countable()` and `count()`. Never compare the array itself with a
  number. Copy the form and the message from `OfferListingFailed.php` (`errorList`):
  `if (!is_null($this->container['x']) && (is_countable($this->container['x']) && count($this->container['x']) < 1))`
  with the message `invalid value for 'x', number of items must be greater than or equal to 1.`
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
- Enums have no test of their own beyond the existing pattern for enums in `tests/Client/Model/`.

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
