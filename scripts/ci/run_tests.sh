#!/bin/bash

set -e -o pipefail
set -x

PROJECT=${PROJECT:-spryker}
YVES_SVC=yves

echo "Waiting for stack to come up (it may take several minutes) ..."
docker wait ${PROJECT}prod_init_1
docker exec -e PUBLIC_YVES_DOMAIN=$YVES_SVC ${PROJECT}devel_yves_1 /entrypoint.sh codeception
