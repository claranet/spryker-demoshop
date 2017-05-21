
# Docker Image claranet/spryker-base

[![build status badge](https://img.shields.io/travis/claranet/spryker-demoshop/master.svg)](https://travis-ci.org/claranet/spryker-demoshop/branches)

<!-- vim-markdown-toc GFM -->
* [What?](#what)
* [Run the Demoshop](#run-the-demoshop)
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
    * [Yves Links not working](#yves-links-not-working)
    * [Elasticsearch 5.0](#elasticsearch-50)

<!-- vim-markdown-toc -->

## What?

This is a dockerized version of the official reference implementation of the
[Spryker Demoshop](https://github.com/spryker/demoshop). It is ready to run
out-of-the-box by automatically pulling all required dependencies and creating
a stack comprising PostgreSQL, Redis, Elasticsearch and Jenkins. During runtime
each of the services gets initialized. 

You can use this repository either as a demonstration for a paradigmatic shop
based on Spryker Commerce Framework or as starting point for the development of
your own implementation beginning with a fork of the demoshop.

The build and init procedures along with further tooling are inherited from the
[claranet/spryker-base](https://github.com/claranet/spryker-base) image. There
you will find the technical design ideas behind the dockerization and answers
to further points like:

* Private Repositories
* Build Layer
* Environments
* Spryker Configuration

## Run the Demoshop

Requires: a recent, stable version of [docker](https://docs.docker.com/) and
[docker-compose](https://docs.docker.com/compose/) on your
[Linux](https://docs.docker.com/engine/installation/linux/ubuntu/)/[MacOS](https://docs.docker.com/docker-for-mac/install/)
box.

If requisites are met running the shop is fairly easy. Just enter these steps:

    $ git clone https://github.com/claranet/spryker-demoshop.git 
    $ cd spryker-demoshop 
    $ ./docker/run prod up

This pulls the docker image, create a network, create all the containers, and
connects them. One of the containers defined in the `docker-compose.yml` file
will carry out the initialization which populates the data stores with dummy
data. 

After the initialization has been finished, you are able to point your browser
to the following URLs:

* Yves via http://localhost:2380
* Zed via http://localhost:2381


## Start Development Environment

If you want to start you own work based on the demoshop you will find the local
development environment interesting. This setup enables you to mount your local
code base into a running spryker setup and see changes take effect immediately. 

Just run `./docker/run devel up` and there you go.

## Common Steps

Furthermore the `./docker/run` script provides you with shortcuts for common tasks:

### Build Image

Just to build the docker image use: `./docker/run build`

This applies to both environments since both are based of the very same image. 

### Create/Destroy Setup

* Create devel env: `./docker/run/build devel up`
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
container to `command: sleep 1000000` in the `docker-compose-devel.yml` and
recreate the container by running `./docker/run devel recreate zed`. 

### Interface to `docker-compose`

Since all this is based on `docker-composer` you might need to call it by
yourself, for example to enter a container via shell: `./docker/run devel
compose exec yves /bin/sh`

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

### Yves Links not working

Links which might point the user to /cart, /login or /checkout are not working properly.

Still looking into this. The links aren't build correctly (just pointing to http://<domain>/).

### Elasticsearch 5.0

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
