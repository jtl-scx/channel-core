<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/scx_logo.png">
</div>

# JTL-SCX Channel-Core

![Releases](https://img.shields.io/github/v/tag/jtl-scx/channel-core)
![Testing](https://github.com/jtl-scx/channel-core/workflows/Testing/badge.svg)
[![codecov](https://codecov.io/gh/jtl-scx/channel-core/branch/master/graph/badge.svg?token=1MK3FX8RCU)](https://codecov.io/gh/jtl-scx/channel-core)

JTL Sales Channel Extension is a product that connects various different eCommerce marketplaces to JTL-Wawi or any other
ERP solution. This repository provides a PHP framework for creating a new SCX channel integration to connect any 
marketplace with SCX.

<div align="center">
  <img src="https://cdn.eazyauction.de/eastatic/JTL-SCX.png">
</div>
 
This PHP framework provides abstractions for

* SCX-Channel-API communication.
* Event handling using RabbitMQ as queue and [jtl/nachricht](https://github.com/jtl-software/nachricht) as messaging framework.
* data handling such as managing category tree, attributes, prices.

## How-To-Start

Use [scx/channel](https://github.com/jtl-scx/channel) to bootstrap a new project

## Start Development

Need to run CLI commands?
````
php bin/Core.php
````

Need a local RabbitMq? 
````
docker-compose up -d
````

See `.env.dist` for development configuration. You may create a `.env.local` to overwrite specific settings
