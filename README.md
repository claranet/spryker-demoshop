# Spryker Demoshop
[![License](https://img.shields.io/github/license/spryker/demoshop.svg)](https://github.com/spryker/demoshop/)

In order to install Spryker Demoshop on your machine, you can follow the instructions described in the link below:

* [Installation - spryker.github.io/getting-started/installation/guide/](http://spryker.github.io/getting-started/installation/guide/)

If you encounter any issues during or after installation, you can first check our Troubleshooting article:

* [Troubleshooting - spryker.github.io/getting-started/installation/troubleshooting/](http://spryker.github.io/getting-started/installation/troubleshooting/)

## Dockerization

### Initialization

Following steps are nececssary to get the demo shop up and running - provided that external resources as configured are existent and reachable:

* `./vendor/bin/console setup:install`
* `./vendor/bin/console import:demo-data`
* `./vendor/bin/console setup:search`
* `./vendor/bin/console collector:search:update`
* `./vendor/bin/console collector:search:export`
* `./vendor/bin/console collector:storage:export`


### Known Bugs

#### Elasticsearch 5.0

ES 5 introduced bootstrap checks which enforce some configuraion parameter in
order to prevent misconfigured es cluster in production. Problem is, that one of those parameters need linux kernel configuration of host system via `sysctl(1)`. This breaks isolation principles. 

So far we rely on ES 2.4 in the first place and will later proceed with newly arrived version 5.0.

For further discussion see: 

* https://www.elastic.co/guide/en/elasticsearch/reference/master/bootstrap-checks.html
* https://www.elastic.co/guide/en/elasticsearch/reference/master/_maximum_map_count_check.html
* https://discuss.elastic.co/t/elasticsearch-5-0-0-aplha4-wont-start-without-setting-vm-max-map-count/57471/12
* https://www.elastic.co/blog/bootstrap_checks_annoying_instead_of_devastating
