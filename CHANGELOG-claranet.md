
# unreleased

## security

* commit 07b32e085 fixes a potential low priority security issue

> Extend .dockerignore to exclude sesible temporary secrets from image build
>  
> This security issue has low impact, but you should update to a version
> which includes this commit!
>  
> If an docker image gets build AFTER the local stack was already run on
> the system that builds the image, it might be, that the docker build
> process adds the `docker/.secret.env` file which contains secrets for
> a local build, dynamically created for the users local dev stack.

## versions

* PHP: 7.2.11 (claranet/php 1.1.14)
* Redis: 4.0.11
* Elasticsearch: 5.6.12
* postgresql: 9.6.10

## changes

* revert splitting Jenkins Dockerfile and the main Dockerfile, [more detailed docs here](docs/jenkins.md)


# 2.32.2 (2018-09-24)

## changes

* fix travis ci

# 2.32.1 (2018-09-24)

## changes

* fix propel:createdb
* Reintroduce distinction of devel/prod via APPLICATION_ENV
* Reduce build time by building the jenkins slave image as a child of the shop
  image
* Fix wrong spryker pathes in jenkins jobs
* Add figure to depict spryker container stack

# 2.32.0 (2018-06-08)

Updates the Spryker Demoshop to version 2.32.0

## versions
* PHP: 7.1.18 (claranet/php 1.1.9)
* PHP Composer: 1.6.5
* NodeJS: 10
* Spryker Demoshop: 2.32
* Jenkins-Slave JRE: 8

## changes

* fix HOST_YVES and HOST_ZED vars in `docker/config_local.php`
* disable opcache, as it breaks the Demoshop since this version

# 2.31.0 (2018-06-07)

Updates the Spryker Demoshop to version 2.31.0

## versions
* PHP: 7.1.18 (claranet/php 1.1.8)
* PHP Composer: 1.6.5
* NodeJS: 10
* Spryker Demoshop: 2.31
* Jenkins-Slave JRE: 8

## changes

* stick with PHP 7.1 as there is an opcache bug in 7.2: https://bugs.php.net/bug.php?id=76029
* use the [Spryker Installer](https://academy.spryker.com/developing_with_spryker/module_guide/utilities/install_tool.html) to build and init the Spryker Shop parts
    * introduces a `config/installer/claranet.yml` file, derived from the `development` manifest
* switch to APPLICATION_ENV=development on default
* install composer with dev bundles to solve some missing includes
* don't install system-packages again, in the jenkins build step
* switch to ElasticSearch 5 as Spryker 2.31 supports and depends on it
* adds backport patch to fix the stores config
* adds support for different databases, based on the STORE
    * and add a store2db map in `docker/config_local.php`

# 2.30.0 (2018-05-30)

Updates the Spryker Demoshop to version 2.30.0

## versions
* PHP: 7.1.17 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 10
* Spryker Demoshop: 2.30.0
* Jenkins-Slave JRE: 8

## changes

* keep to PHP 7.1.17 as the spryker demoshop currently drops some exceptions regarding PHP 7.2
* update Demoshop to 2.30.0
* switch to NodeJS: 10
* `docker/run`
    * get rid of the `envsubst` (gettext)
    * get rid of `pwgen`, used /dev/random instead
    * auto generation of credentials changed to a template approach
    * generate `docker-compose.yml` each run instead of piping result into
      `docker-compose`
* let phpfpm logs go to stdout/stderr again
* add spryker mutlistore support
    * `docker/config_local.php` switch to _$STORES_ from env to calculate available stores (for multistore)
    * `Dockerfile` add _$DEFAULT\_STORE_ to define the fallback store
    * `start > nginx` prepare _/etc/nginx/conf.d/spryker.conf_ mapping for _$DEFAULT\_STORE_ and _$STORES_

# 2.29.0 (2018-05-24)

Updates the Spryker Demoshop to version 2.29.0

## versions
* PHP: 7.1.17 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 6.x.x
* Spryker Demoshop: 2.29.0
* Jenkins-Slave JRE: 8

## changes

* add rabbitmq to docker-compose, config_local.php and Dockerfile
* update spryker demoshop to 2.29.0

# 2.28.0 ( 2018-05-24 )

Marks version 2.28.0 of the spryker demoshop image. It is the first version
using the new [Claranet PHP parent image](https://github.com/claranet/php).

Starting with this version, spryker-base is gone and features of spryker-base
are now split in the general purpose PHP parent image and this spryker-demoshop.

Most of the spryker-base code is now located within claranet/php; all spryker
related steps are merged into this repository, making it easier for customers
to see which steps are available.

Use this repo as a skeleton for your new spryker projects, so you can benefit
from the dockerized stack, we built for you.

## versions
* PHP: 7.1.17 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 6.x.x
* Spryker Demoshop: 2.28.0
* Jenkins-Slave JRE: 8

## changes

* switch to claranet/php parent image
* switch to PHP 7.1.17
* add jenkins master/slave with specialized jenkins slave flavoured spryker image
* upgrade docker-compose stack to match recent docker images and make use of docker-compose 3.4 config file features to simplify our own setup
* remove `docker/run devel|prod build` and only serve `docker/run build` now (this builds the main docker image and the jenkins flavour as well)
* rename `docker/build.conf.sh` to `docker/project.conf.sh` to match the meaning of this file
* apply a lot of bugfixes to `config_local.php` and remove deprecated config constance usage
* generate local-dev secrets for redis/postgres per cloned repo; so there is no pregenerated secret and redis now is configured to auth clients
* add heartbeat and readiness probes for spryker container
* split nginx / phpfpm at runtime, not build time

# 2.28.0 (2018-04-19)

* merge changes from upstream (tag 2.28)
* switch from alpine to debian stretch as base image (via spryker-base)

# 2.27.0

* merge changes from upstream (tag 2.27)

# 2.27.1

* [fix] swap `currencyIsoCode` with `currencyIsoCodes` stores config properties
