<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# JTL-SCX Channel-Core

![Testing](https://github.com/jtl-scx/channel-core/workflows/Testing/badge.svg)

JTL Sales Channel Extension is a product to connect various different eCommerce Marketplace with JTL-Wawi or any other
ERP solution. This Repository provide a PHP-Framework for creating a new SCX-Channel-Integrations to connect any
eCommerce Marketplace with SCX.

<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/JTL-SCX.png">
</div>
 
This PHP-Framework abstraction for

* SCX-Channel-API communication.
* Event Handing using RabbitMQ as queue and [jtl/nachricht](https://github.com/jtl-software/nachricht) as message broker.
* Toolbox for Data handing such as managing category tree, attributes, prices.

## How-To-Start

Use [scx/channel](https://github.com/jtl-scx/channel) to bootstrap a new project

## Start Development

Need to run CLI Commands?
````
php bin/Core.php
````

Need a local rabbitMq? 
````
docker-compose up -d
````

See `.env.dist` for development configuration. You may create a `.env.local` to overwrite specific settings
