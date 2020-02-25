<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# SCX-Channel-Core

[![Build Status](https://travis-ci.org/jtl-scx/channel-core.svg?branch=master)](https://travis-ci.org/jtl-scx/channel-core)

JTL Sales Channel Extension is a product to connect various different eCommerce Marketplace with JTL-Wawi or any other ERP solution. This Repistory provide a PHP-Framework for creating new SCX-Channel-Integrations to connect any eCommerce Marketplace with SCX. 

<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/JTL-SCX.png">
</div>

This Framework for SCX-Channel-Integrations provide abstraction for

* SCX-Channel API communication.
* Event Handing using RabbitMQ as queue and [jtl/nachricht](https://github.com/jtl-software/nachricht) as message broker.
* Toolbox for Data handing such as managing category tree, attributes, prices.

## CLI Commands

Under `bin/Core.php` you will find a executable CLI tool (based on symfony/console) which will give you a wide range 
on tool which might help by setting up your own SCX-Channel integration.

### Command `scx-api:get.events`

Read events available through `GET /channel/events` dispatch them in messages queues, using jtl/nachricht and 
acknowledge then by calling `DELETE /channel/events`. To consume such events use `scx-channel:event.consume`

### Command `scx-channel:event.consume`

Consume all messages available through RabbitMQ

### Namespace `scx-api`

Contain command to send our receive data from SCX-Channel-Api

### Namespace `scx-channel`

Contain command which may be helpful when setting up your own Channel Integration.

### Namespace `helper`

The namespace helper provide tool to create Seller-Events for testing propose. 

For example:
````
php bin/Core helper:emit.OfferNewEvent example/OfferNew.json $TESTSELLER
````

## Contribution

Need to run CLI Commands?
````
php bin/Core.php
````

Need a local rabbitMq? 
````
docker-compose up -d
````

See `.env.dist` for development configuration. You may create a `.env.local` to overwrite specific settings
