
This is a docker-enabled demoshop version of the official [spryker demoshop](https://github.com/spryker/demoshop). It makes running a local demo of the shop very easy with providing a one-line-to-does-it-all shortcut.


# The one-line-does-it-all-for-you

Requires: a recent, stable version of [docker](https://docs.docker.com/) and [docker-compose](https://docs.docker.com/compose/) on your [Linux](https://docs.docker.com/engine/installation/linux/ubuntu/)/[MacOS](https://docs.docker.com/docker-for-mac/install/) system


## TLTR

```
git clone https://github.com/claranet/spryker-demoshop.git && cd spryker-demoshop/docker/ && docker-compose -p sprykerdemoshop up
```

After the initialization is finished, you should be able to serve...

* Yves via http://localhost:2380
* Zed via http://localhost:2381


## Long version

This repository is the origin for the [docker-hub claranet/spryker-demoshop](https://hub.docker.com/claranet/spryker-demoshop). It is essentially a copy of the latest spryker-demoshop release with small, just enough to work, modifications to work within docker containers.

It makes the spryker-demoshop work with [alpinelinux](https://alpinelinux.org/) and extends the repository by...

* a [Dockerfile](Dockerfile)
* a [docker-compose.yml](docker/docker-compose.yml)
* some demo scenarios for how to leverage our [spryker-base image](https://hub.docker.com/claranet/spryker-base) image (aka "best practices")

See [the docker folder](docker) for more details.

## Dockerization

### Initialization

Following steps are necessary to get the demo shop up and running - provided that external resources as configured are existent and reachable:

* `./vendor/bin/console setup:search`
* `./vendor/bin/console setup:install`
* `./vendor/bin/console import:demo-data`
* `./vendor/bin/console collector:search:update`
* `./vendor/bin/console collector:search:export`
* `./vendor/bin/console collector:storage:export`


### Known Bugs

If you find a bug not listed here, please [report](https://github.com/claranet/spryker-demoshop/issues) them!

#### Yves - Links for /cart /login and /checkout are not working

Still looking into this. The links aren't build correctly (just pointing to http://<domain>/).

#### Elasticsearch 5.0

ES 5 introduced bootstrap checks which enforce some configuration parameter in
order to prevent misconfigured es cluster in production. Problem is, that one of those parameters need linux kernel configuration of host system via `sysctl(1)`. This breaks isolation principles. 

So far we rely on ES 2.4 in the first place and will later proceed with newly arrived version 5.0.

Note: [That Spryker is only supporting ES version 2.4.x](http://spryker.github.io/getting-started/system-requirements/#elasticsearch).

For further discussion see: 

* https://www.elastic.co/guide/en/elasticsearch/reference/master/bootstrap-checks.html
* https://www.elastic.co/guide/en/elasticsearch/reference/master/_maximum_map_count_check.html
* https://discuss.elastic.co/t/elasticsearch-5-0-0-aplha4-wont-start-without-setting-vm-max-map-count/57471/12
* https://www.elastic.co/blog/bootstrap_checks_annoying_instead_of_devastating
