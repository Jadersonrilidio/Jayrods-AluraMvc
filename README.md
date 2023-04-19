## Alura Videos

A platform for storing videos of registered users.


## About

Project developed during Alura's PHP courses concerning MVC arquitecture, security and API, application of good practices and adequacy of PSRs, among other implemented features as listed below:

 - Autoload via PSR-4;
 - Authentication and authorization by PHP Sessions;
 - API JWT authentication;
 - Implementation of FlashMessages via Traits;
 - Controller classes standardization by PSR-15;
 - Dependency injection container with PHP-DI (implementation of PSR-11);
 - Implementation of Plates as template engine.


## Installation and settings

Clone the project from the repository:

```bash
    $ git clone https://github.com/Jadersonrilidio/alura-videos-php
```

Initialize composer:

```bash
    $ composer install
```

Create `.env` file and set the environment variables accordingly as example below:

```bash
    DB_DRIVE=sqlite
    DB_PATH=/database/
    DB_NAME=database.sqlite
```

Run the composer script to create database tables (in sqlite).

```bash
    $ composer dbinit
```

Then run the application using the composer script:

```bash
    $ composer serve
```

witch is set to run a PHP default server, configured on `composer.json` file as below:

```json
    {
        "scripts": {
            "serve": [
                "Composer\\Config::disableProcessTimeout",
                "php -S localhost:8000 -t public/"
            ]
        }
    }
```

Finally your application is set and running for trial.
