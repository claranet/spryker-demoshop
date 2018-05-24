
# 2.30.0 (unreleased)

Updates the Spryker Demoshop to version 2.30.0

Spryker now supports PHP 7.2.x, so we update PHP to 7.2.5 as well.

**versions**
* PHP: 7.2.5 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 8.x.x
* Spryker Demoshop: 2.29.0
* Jenkins-Slave JRE: 8

**changes**
* switch to PHP 7.2.5
* update Demoshop to 2.29.0
* switch to NodeJS: 10

# 2.29.0 (2018-05-24)

Updates the Spryker Demoshop to version 2.29.0

**versions**
* PHP: 7.1.17 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 6.x.x
* Spryker Demoshop: 2.29.0
* Jenkins-Slave JRE: 8

**changes**
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

**versions**
* PHP: 7.1.17 (claranet/php 1.1.7)
* PHP Composer: 1.6.5
* NodeJS: 6.x.x
* Spryker Demoshop: 2.28.0
* Jenkins-Slave JRE: 8

**changes**
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
