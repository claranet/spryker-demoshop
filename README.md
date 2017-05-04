
This is a docker-enabled demoshop version of the official [spryker demoshop](https://github.com/spryker/demoshop). It makes running a local demo of the shop very easy with providing a one-line-to-do-it-all shortcut.


# The one-line-does-it-all-for-you

Requires: a recent, stable version of [docker](https://docs.docker.com/) and [docker-compose](https://docs.docker.com/compose/) on your [Linux](https://docs.docker.com/engine/installation/linux/ubuntu/)/[MacOS](https://docs.docker.com/docker-for-mac/install/) system

## TLTR

```
git clone https://github.com/claranet/spryker-demoshop.git && cd cd spryker-demoshop/docker/ && docker-compose -p sprykerdemoshop up
```

## Long version

This repository is the origin for the [docker-hub claranet/spryker-demoshop](https://hub.docker.com/claranet/spryker-demoshop). It is essentially a copy of the latest spryker-demoshop release with small, just enough to work, modifications to work within docker containers.

It makes the spryker-demoshop work with [alpinelinux](https://alpinelinux.org/) and extends the repository by...

* a [Dockerfile](Dockerfile)
* a [docker-compose.yml](docker/docker-compose.yml)
* some demo scenarios for how to leverage our [spryker-base image](https://hub.docker.com/claranet/spryker-base) image (aka "best practices")

See [the docker folder](docker) for more details.

## Dockerization

### Initialization

Following steps are nececssary to get the demo shop up and running - provided that external resources as configured are existent and reachable:

* `./vendor/bin/console setup:search`
* `./vendor/bin/console setup:install`
* `./vendor/bin/console import:demo-data`
* `./vendor/bin/console collector:search:update`
* `./vendor/bin/console collector:search:export`
* `./vendor/bin/console collector:storage:export`


### Known Bugs

#### Spryker - Search Setup

The console command `setup:search` integrates two tasks of different nature: 

* Create the indices in elasticsearch 
* Generate code which serves as mapping bridge between spryker and ES

The former is an init task needs to be ran at runtime if external resources are
available, the ladder one is a build time task creating code which should be
available in all containers. We've asked Vladimir (Volodymyr) Lunov of Spryker
to split these console asks. 

As workaround we make `./src/Generated` a volume shared by all containers and
put the `setup:search` task into the init stage.

#### Elasticsearch 5.0

ES 5 introduced bootstrap checks which enforce some configuraion parameter in
order to prevent misconfigured es cluster in production. Problem is, that one of those parameters need linux kernel configuration of host system via `sysctl(1)`. This breaks isolation principles. 

So far we rely on ES 2.4 in the first place and will later proceed with newly arrived version 5.0.

Note: That Spryker is currently only supporting ES version 2.

For further discussion see: 

* https://www.elastic.co/guide/en/elasticsearch/reference/master/bootstrap-checks.html
* https://www.elastic.co/guide/en/elasticsearch/reference/master/_maximum_map_count_check.html
* https://discuss.elastic.co/t/elasticsearch-5-0-0-aplha4-wont-start-without-setting-vm-max-map-count/57471/12
* https://www.elastic.co/blog/bootstrap_checks_annoying_instead_of_devastating
