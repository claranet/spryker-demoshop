#!/bin/sh

# this makes importing data way faster!
sectionText "Patch chunk size in AbstractCollector to increase performance"
CHUNK_SIZE_FILE="$WORKDIR/vendor/spryker/collector/src/Spryker/Zed/Collector/Business/Collector/AbstractCollector.php";
if [ -f "$CHUNK_SIZE_FILE" ]; then
  sed -i "s/protected \$chunkSize = 1000;/protected \$chunkSize = $INIT_COLLECTOR_CHUNK_SIZE;/" $CHUNK_SIZE_FILE
fi

sectionText "Export to elasticsearch"
do_per_store $CONSOLE collector:search:export

sectionText "Export to storage redis"
do_per_store $CONSOLE collector:storage:export
