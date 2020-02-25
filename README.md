<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# JTL-SCX Channel-Core

[![Build Status](https://travis-ci.org/jtl-scx/channel-core.svg?branch=master)](https://travis-ci.org/jtl-scx/channel-core)

JTL Sales Channel Extension is a product to connect various different eCommerce Marketplace with JTL-Wawi or any other ERP solution. This Repistory provide a PHP-Framework for creating new SCX-Channel-Integrations to connect any eCommerce Marketplace with SCX. 

<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/JTL-SCX.png">
</div>

This Framework for SCX-Channel-Integrations provide abstraction for

* SCX-Channel API communication.
* Event Handing using RabbitMQ as queue and [jtl/nachricht](https://github.com/jtl-software/nachricht) as message broker.
* Toolbox for Data handing such as managing category tree, attributes, prices.

## Development

Need to run CLI Commands?
````
php bin/Core.php
````

Need a local rabbitMq? 
````
docker-compose up -d
````

See `.env.dist` for development configuration. You may create a `.env.local` to overwrite specific settings
