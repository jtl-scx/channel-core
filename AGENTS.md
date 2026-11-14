# channel-core

PHP library (`jtl-scx/channel-core` on Packagist) with the shared code of the JTL-SCX channel
integrations: the client for the SCX Channel API, the event loop, the console commands and the meta
data handling. A channel integration connects one marketplace to that API and uses this library
through Composer. It needs PHP 8.3, 8.4 or 8.5 and builds on Symfony 7.4, Guzzle, RabbitMQ with
`jtl/nachricht`, and `jtl-scx/api-base-client` for authentication.

> The maintainers develop this repository inside a private workspace that holds their general
> rules for code style, tests and commits. This file contains only what is specific to this
> repository. If a rule you need is not written here, follow the existing code and ask in the pull
> request.

## Where things happen

The only autoload root is `JTL\SCX\Lib\Channel\` in `src/`. The tests use the same namespace in
`tests/`.

| Namespace (below `JTL\SCX\Lib\Channel`) | Path | What happens there |
|---|---|---|
| `Client\Api\<Topic>` | `src/Client/Api/` | The API classes with their `Request/` and `Response/` classes. A request class holds the URL and the HTTP method. |
| `Client\Model` | `src/Client/Model/` | The data models of the Channel API. Own rules, see below. |
| `Client` | `src/Client/` | `ObjectSerializer` (JSON to model and back) and `Event\EventType` (the seller event types). |
| `Event` | `src/Event/` | The event loop: the command that gets the seller events, `EventFactory`, the message classes in `Seller\`, the emitter. |
| `Core` | `src/Core/` | `AbstractApplicationContext` (builds the container), `Command\`, `Message\AbstractListener`, `Log\`, `Metrics\`, `I18n\`. |
| `Contract` | `src/Contract/` | Interfaces that a channel implements or uses: the `MetaData\*Loader` interfaces, `Core\Log\ScxLogger`, `Core\Message\*RelatedMessage`. |
| `ChannelApi`, `Notification`, `Order`, `Seller` | `src/ChannelApi/`, `src/Notification/`, `src/Order/`, `src/Seller/` | Messages that a channel emits to report a result, each with a listener that calls the API. |
| `MetaData` | `src/MetaData/` | Category tree, attributes, shipping attributes, price types: mappers, updaters, `Default*Loader` placeholders. |
| `Report\SellerInventory` | `src/Report/` | Sends the seller inventory report. |
| `Helper\Command` | `src/Helper/Command/` | Commands to try things by hand: `helper:emit.*` and `helper:work`. |
| `Controller`, `Template` | `src/Controller/`, `src/Template/` | Base class and Twig renderer for the sign-up page of a channel. |

Most API classes are named `<Topic>Api` (`OrderApi`, `OfferApi`, `EventApi`). The exceptions are
`Attribute\AttributesApi`, `Meta\PaymentRulesApi` and `Meta\ShippingRulesApi`.

Entry points:

- Console commands. Every class that extends `Core\Command\AbstractCommand` is a command. The name
  is in its `#[AsCommand]` attribute. `config/core-service.yaml` registers all classes in `src/`
  as services and tags the commands.
- `bin/Core.php` is the development CLI of this repository. A channel has its own entry script
  that extends `AbstractApplicationContext` in the same way.
- Message listeners. `jtl/nachricht` finds every class that implements its `Listener` interface in
  `src/` of the channel and in `src/` of this library (without `src/Client/`). A listener method is
  a public method with the message class as parameter type. There is no listener registry.
- This library has no HTTP routes, no cron definitions and no database code.

Main flows:

- Seller event, incoming: `scx-api:get.events` (`Event\Command\ScxApiEventConsumeCommand`) ->
  `Client\Api\Event\EventApi::get()` -> `EventType` selects the model class -> `ObjectSerializer`
  builds the model -> `EventContainer` -> `EventFactory` builds the message from `Event\Seller\`
  -> `SellerEventEmitter` -> RabbitMQ -> `EventApi::ack()` for the emitted ids. Then
  `chn:message.consume` (`Core\Command\MessageConsumeCommand`) gives each message to its listener
  methods.
  - An event without `type`, `id`, `event` or `createdAt`, or one that throws while its model is
    built, becomes an `ErroneousEvent`. It is logged as "Erroneous Event ignored". It is not
    emitted and not acknowledged.
  - The event is acknowledged as soon as it is on the queue. When a listener throws,
    `AbstractListener::onError()` logs and throws again, and `jtl/nachricht` puts the message back
    with its retry delay (120 seconds for a seller event, see `Event\AbstractEvent`). When the
    retries are used up, the message goes to a dead letter queue. `queue:dead-letter.retry` moves
    it back.
- Call to the API, outgoing: the channel builds a model from `Client\Model` -> a request from
  `Client\Api\<Topic>\Request` -> the API class -> `AuthAwareApiClient::request()` from
  `jtl-scx/api-base-client` -> a response from `Client\Api\<Topic>\Response`. Example:
  `Order` -> `OrderList` -> `CreateOrderRequest` -> `OrderApi::create()` -> `CreateOrdersResponse`.
- Result message, outgoing through the queue: the channel emits for example
  `ChannelApi\SendOfferListingSuccessfulMessage` -> `ChannelApi\SendOfferListingResultListener`
  -> `Client\Api\Offer\OfferApi::markListed()`.
- Meta data: `scx-api:put.category-tree` (`Core\Command\ImportCategoryTreeCommand`) ->
  `Contract\MetaData\MetaCategoryLoader` of the channel -> `MetaData\CategoryTreeUpdater` ->
  `Client\Api\Category\CategoryApi`. The attribute commands work in the same way.

What a channel implements: a subclass of `AbstractApplicationContext`, listeners that extend
`Core\Message\AbstractListener` for the messages in `Event\Seller\`, and the loader interfaces in
`Contract\MetaData\` that its commands need. It overrides the loader services in its own service
file. The library itself listens to `AttributesUpdateRequestEvent`
(`MetaData\Attribute\AttributeUpdateRequestListener`,
`MetaData\ShippingAttribute\SellerShippingAttributeUpdateRequestListener`).

Wiring a seller event. The event loop knows a seller event only when all of these exist:

1. The model `SellerEvent<Name>` in `src/Client/Model/`, and the value of the event type in the
   enum class `SellerEventTypeList` there.
2. In `src/Client/Event/EventType.php`: a constant with that value, the `@method` line, and a
   `case` in `getEventModelClass()` that returns the model class.
3. A message class in `src/Event/Seller/` that extends `AbstractEvent`. Its constructor takes
   `$id`, `$clientVersion`, `$createdAt` and the model, in this order, because `EventFactory`
   calls it with these four arguments. It has `getEvent()`. Copy `OfferNewEvent.php`.
4. A `case` in `src/Event/EventFactory.php` that selects the message class.
5. The model in the `@return` type of `getEvent()` in
   `src/Client/Api/Event/Model/EventContainer.php`. This is documentation only.
6. The cases in `tests/Client/Event/EventTypeTest.php` and `tests/Event/EventFactoryTest.php`, and
   a test for the message class in `tests/Event/Seller/`.

Nothing in this repository is generated. Module with its own rules:
[`src/Client/Model/AGENTS.md`](src/Client/Model/AGENTS.md), for the models and their tests.

## Commands

Run all commands in the repository root. They need a PHP CLI (8.3 to 8.5) with Composer and every
extension that `composer.json` and the packages in `composer.lock` require (`ext-*`), among them
`curl`, `json`, `mbstring`, `pcntl` and `sockets`. The dependencies are public.

```bash
composer install

vendor/bin/phpunit --no-coverage                                     # all tests, some seconds
vendor/bin/phpunit --no-coverage tests/Event/EventFactoryTest.php    # one class
vendor/bin/phpunit --no-coverage tests/Client/Model/AllowedValueTest.php --filter it_has_expected_interface

composer phpstan      # static analysis, level 9, with phpstan-baseline.neon
composer phpcs-dry    # code style, check only
composer phpcs        # code style, fix

php bin/Core.php list                                                # all console commands
php bin/Core.php helper:work --type=SellerOfferNew "$(cat example/OfferNew.json)"
```

The tests need no service, no database and no environment variable.

The CI (`.github/workflows/ci.yml`) runs on every push. It runs `composer phpstan` and
`composer phpcs-dry` on PHP 8.4, and `vendor/bin/phpunit --coverage-clover=coverage.xml` on PHP
8.3, 8.4 and 8.5. The local commands differ only in `--no-coverage`.

To try a command by hand:

- `helper:work` builds a seller event from a payload, validates it against its model and calls
  the listener directly, without the queue. It takes the payload as inline JSON, as above, or as an
  absolute path to a JSON file. `--type` is the name of a constant in `EventType`. In this
  repository the command above ends with exit code 1 and "No listener is registered", because the
  listeners for offer and order events are in the channels.
- `bin/Core.php` reads `.env` when it exists and `.env.dist` when it does not, then `.env.local`.
  Put your own values in `.env.local`.
- The `scx-api:*` commands call the Channel API. They need `SCX_CHANNEL_API_HOST` and
  `SCX_CHANNEL_API_REFRESH_TOKEN`. The host in `.env.dist` is the sandbox.
- `chn:message.consume`, `queue:dead-letter.retry` and `helper:emit.*` need a RabbitMQ with the
  delayed message exchange plugin, set by the `RABBITMQ_*` variables. Without a broker at
  `RABBITMQ_HOST`, `chn:message.consume` ends with a connection error.

## Conventions

- A test class needs `#[CoversClass]`. `phpunit.xml` sets `requireCoverageMetadata`, and a test
  without it is reported as risky.
- phpstan skips `src/Client/Api`, `src/Client/Model`, `src/Client/ObjectSerializer.php` and two
  more files (`phpstan.neon`). Only the tests and php-cs-fixer check this code.
- A command extends `Core\Command\AbstractCommand` and gets its name from `#[AsCommand]`. The
  existing prefixes are `scx-api:` (calls the Channel API), `chn:`, `queue:` and `helper:`.
- A listener extends `Core\Message\AbstractListener`. A message that implements an interface from
  `Contract\Core\Message\` (for example `SellerIdRelatedMessage`) gets that id into the log
  context of every log line.
- Log through `Contract\Core\Log\ScxLogger`.
- New code outside `src/Client/Model/` declares `strict_types`. A few existing files do not; do
  not convert them in passing.

## Boundaries

- Channel integrations in other repositories install this package from Packagist. No class in
  `src/` is marked as internal, so a channel can use every public and protected class, method,
  constructor and constant. Ask before you rename or remove one, change its signature, or add a
  required constructor parameter to a service.
- Channels call the console commands by name, override the services of `config/core-service.yaml`
  and set the variables of `.env.dist`. Ask before you rename one of them.
- The queue name of a message is its class name. Ask before you rename or move a message class:
  messages in the old queue are then not consumed.
- `config/core-service.yaml` loads the whole of `src/`, so a new class becomes a service in every
  channel. A command, a listener and every class they use stay in the container. Give them
  constructors that can be autowired, or the container of the channel does not build.
- A dependency in `require` of `composer.json` is a dependency of every channel. Ask before you
  add one or move one to a new major version. `twig/twig` is in `require-dev` only: a channel
  that uses `Template\TwigTemplateRenderer` requires it itself.
- A release is a tag `MAJOR.MINOR.PATCH` without prefix on `master`, published as a GitHub release
  with generated notes. Packagist takes the version from the tag. There is no release workflow and
  no changelog file. The branches `1.x` and `2.x` hold the old major versions. Do not create a tag
  or a release yourself.
- The scripts in `client_example/` call the production API (`Configuration::HOST_PRODUCTION`),
  and `GetEvents.php` acknowledges the events it reads. Do not run them.

## Pitfalls

- An event that `EventFactory` does not know is logged as "could not be mapped". It is not put on
  the queue and it is not acknowledged. A new seller event works only when it is wired in all
  places, see "Wiring a seller event".
- The API classes do not call `valid()` on a model before they send it. Only the `helper:`
  commands validate. Call `valid()` yourself when you need the check.
- Most `Default*Loader` classes in `src/MetaData/` throw "Please implement ...". This is the
  intended signal for a channel that did not register its own loader.
- `helper:emit.ChannelNotification` is different from the other `helper:emit.*` commands. It
  builds a notification message from its arguments, not a seller event from a JSON file.

## Where to find more

- Channel API reference: <https://developer.jtl-software.com/marketplace-channels/api-reference/channel>
- Channel API specification (OpenAPI, one JSON file):
  <https://developer.jtl-software.com/openapi/marketplace-channels/channel.json>
- Guides for events, offers and orders:
  <https://developer.jtl-software.com/marketplace-channels/guides/channel-api-overview>
- The skeleton for a new channel: <https://github.com/jtl-scx/channel>
- `README.md` for the purpose of the library, `.env.dist` for every setting with its comment.
- Example payloads of seller events: `example/*.json`.
- The messaging library: <https://github.com/jtl-software/nachricht>
