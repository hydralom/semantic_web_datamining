# Dev env

## Build required docker images

To start local development environment run :

```bash
cd docker-compose

make build
```

## Install project

__⚠️ You need `php7.2` (or higher) + `composer`__ : [install tutorial](https://davidperonne.com/installation-de-php-7-et-composer-sur-windows-10-en-mode-natif/)

To install project (install composer) :

```bash
make install
```

## How to run project

start project :
```sh
make up
```

stop project :
```sh
make down
```
