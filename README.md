# SCX-Channel-Core

The core Framework for SCX Channel Application provide abstraction for

* SCX Channel API communication
* Event Handing using RabbitMQ and jtl/nachricht
* Toolbox for Meta-Data handing (Category Tree, Attributes, PriceTypes)

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
