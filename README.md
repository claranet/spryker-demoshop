# Docker Image claranet/spryker-demoshop

[![build status badge](https://img.shields.io/travis/claranet/spryker-demoshop/master.svg)](https://travis-ci.org/claranet/spryker-demoshop/branches)

**DEPRECATION NOTICE: We dropped alpine support in favor of debian stretch! If you require alpine, please use versions prior 2.28.0**
**Also note: The parent image switched from `claranet/spryker-base` to `claranet/php`, which breaks the previous `docker/` filesystem structure!**

<!-- vim-markdown-toc GFM -->

* [What?](#what)
* [Run the Demoshop](#run-the-demoshop)
* [Exposed Services](#exposed-services)
* [Start Development Environment](#start-development-environment)
* [Common Steps](#common-steps)
    * [Build Image](#build-image)
    * [Create/Destroy Setup](#createdestroy-setup)
    * [Operations While Setups is Running](#operations-while-setups-is-running)
        * [Refetch Dependencies](#refetch-dependencies)
        * [Rebuild and Recreate just Yves/Zed Container](#rebuild-and-recreate-just-yveszed-container)
    * [Interface to `docker-compose`](#interface-to-docker-compose)
    * [Debug Failed Build](#debug-failed-build)
* [Known Issues](#known-issues)
    * [Elasticsearch 5.0](#elasticsearch-50)

<!-- vim-markdown-toc -->

## What?

This is a dockerized version of the official reference implementation of the
[Spryker Demoshop](https://github.com/spryker/demoshop). It is ready to run
out-of-the-box by automatically pulling all required dependencies and creating
a stack comprising PostgreSQL, Redis, Elasticsearch and Jenkins. During runtime
each of the services gets initialized.

You can use this repository either as a demonstration for a paradigmatic shop
based on Spryker Commerce OS or as starting point for the development of
your own implementation beginning with a fork of the demoshop.

The build and start procedure along with further tooling are inherited from the
[claranet/php](https://github.com/claranet/php) image. There
you will find the technical design ideas behind this dockerization and answers
to further points like:

* Private Repositories
* Build Layer
* Environments
* `docker/` filesystem structure
* sections / subsection & steps concept

## Run the Demoshop

Requires: a recent, stable version of [docker](https://docs.docker.com/) and
[docker-compose](https://docs.docker.com/compose/) (with docker-compose.yml 3.4 support) on your
[Linux](https://docs.docker.com/engine/installation/linux/ubuntu/) or [MacOS](https://docs.docker.com/docker-for-mac/install/)
system.

If requisites are met, running the shop is fairly easy. Just enter these steps:

    $ git clone https://github.com/claranet/spryker-demoshop.git
    $ cd spryker-demoshop
    $ ./docker/run devel pull
    $ ./docker/run devel up

This pulls the docker image, create a network, create all the containers, bind
mounts your local code into the container in order to enable you to live-edit
from outside, connects the container to each other and finally exposes the
public services. Like Yves, Zed, Jenkins-Master, Postgresql and Elasticsearch.

After the initialization has been finished, you are able to point your browser
to the following URLs:

* Yves: http://localhost:20100
* Zed: http://localhost:20200
* Jenkins-Master: http://localhost:20300
* Elasticsearch: http://localhost:20500
* Postgresql: localhost:20600

## Exposed Services

Several services are being exposed by the docker composable stack. In order to
run stacks in parallel and prevent port collisions we need to align port
allocation.

Therefore the following scheme has been implemented: The port number is encoded
like this: **ECC00**

* **E** - Environment
    * 1 - production
    * 2 - development
* **CC** - Component
    * 01 - yves
    * 02 - zed
    * 03 - jenkins
    * 05 - elasticsearch
    * 06 - postgresql
    * 07 - rabbitmq

## Start Development Environment

If you want to start you own work based on the demoshop you will find the local
development environment interesting. This setup enables you to mount your local
code base into a running spryker setup and see changes take effect immediately.

Just run `./docker/run devel up` and there you go.

## Common Steps

Furthermore the `./docker/run` script provides you with shortcuts for common tasks:

### Build Image

Just to build the docker image use: `./docker/run build`

This applies to both environments since both are based of the very same image. It will
build the main spryker-demoshop image as well as a specialized jenkins-slave flavour from
the spryker-demoshop image.

### Create/Destroy Setup

* Launch devel env: `./docker/run devel up`
* Destroy devel env including the removal of allocated unnamed volumes: `./docker/run devel down -v`

### Operations While Setups is Running

#### Refetch Dependencies

Rerun the process which resolves the PHP and Node dependencies within the
running Yves/Zed containers: `./docker/run devel build-deps`

#### Rebuild and Recreate just Yves/Zed Container

In case you want to rebuild the shop image and just want to recreate the Yves
and Zed container while keeping all of the data containers (redis, es, psql)
running: `./docker/run devel rebuild`

If you just want to recreate those containers without rebuilding them run:
`./docker/run devel recreate`

While debugging it might be useful instead of letting `/entrypoints.sh`
initialize the container to skip this steps and check for yourself. You could
do this by changing the `command: run-zed` directive of the concerning
container to `command: sleep 1w` in the `docker-compose-devel.yml` and
recreate the container by running `./docker/run devel recreate zed`.

### Interface to `docker-compose`

Since all this is based on `docker-composer` you might need to call it by
yourself, for example to enter a container via shell:
`./docker/run devel compose exec yves bash`

### Debug Failed Build

If the output of the build is not that telling and you are in need of a deeper
debug session, consider the following steps in order to resurrect the died
intermediate build container:

    ./docker/run build
    # assumed that the last created container is the failed intermediate build container
    docker commit $(docker ps -lq) debug
    docker run --rm --it debug /bin/sh

And here you go in investigating the cause for the build failure.


## Known Issues

If you find a bug not listed here, please [report](https://github.com/claranet/spryker-demoshop/issues) them!

### Elasticsearch 5.0

**NOTE: will be fixed with the 2.31 spryker-release!**

ES 5 introduced bootstrap checks which enforce some configuration parameter in
order to prevent misconfigured es cluster in production. Problem is, that one
of those parameters need linux kernel configuration of host system via
`sysctl(1)`. This breaks isolation principles.

So far we rely on ES 2.4 in the first place and will later proceed with newly
arrived version 5.0.

Note: [That Spryker is only supporting ES version 2.4.x](http://spryker.github.io/getting-started/system-requirements/#elasticsearch).

For further discussion see:

* https://www.elastic.co/guide/en/elasticsearch/reference/master/bootstrap-checks.html
* https://www.elastic.co/guide/en/elasticsearch/reference/master/_maximum_map_count_check.html
* https://discuss.elastic.co/t/elasticsearch-5-0-0-aplha4-wont-start-without-setting-vm-max-map-count/57471/12
* https://www.elastic.co/blog/bootstrap_checks_annoying_instead_of_devastating
