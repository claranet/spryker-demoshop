#!/bin/sh

wait_for_http_service http://$ELASTICSEARCH_HOST:$ELASTICSEARCH_PORT/_cluster/health

$PHP $WORKDIR/docker/bin/patch_elasticsearch_index_jsons.php $WORKDIR/

do_per_store $CONSOLE setup:search
