#!/bin/sh

prepare_elasticsearch_index_descriptions() {
  $PHP $WORKDIR/docker/bin/patch_elasticsearch_index_jsons.php $WORKDIR/
}

prepare_collector_export_chunk_size() {
  CHUNK_SIZE_FILE="$WORKDIR/vendor/spryker/collector/src/Spryker/Zed/Collector/Business/Collector/AbstractCollector.php";
  if [ -f "$CHUNK_SIZE_FILE" ]; then
    sectionText "Set collector chunk size to $INIT_COLLECTOR_CHUNK_SIZE to improve the export performance"
    sed -i "s/protected \$chunkSize = 1000;/protected \$chunkSize = $INIT_COLLECTOR_CHUNK_SIZE;/" $CHUNK_SIZE_FILE
  fi
}

wait_for_http_service http://$ELASTICSEARCH_HOST:$ELASTICSEARCH_PORT/_cluster/health
wait_for_tcp_service $ZED_DATABASE_HOST $ZED_DATABASE_PORT

sectionText "Set elasticsearch index properties: shards=$ES_INDEX_NUMBER_OF_SHARDS, replicas=$ES_INDEX_NUMBER_OF_REPLICAS"
prepare_elasticsearch_index_descriptions

prepare_collector_export_chunk_size

sectionText "Run spryker installer"
for store in ${STORES}; do
  spryker_installer --sections=database-migrate "$store"
done
