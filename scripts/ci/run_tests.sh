#!/bin/bash

set -e -o pipefail

PROJECT=${PROJECT:-spryker}
ENV=${ENV:-prod}
YVES_SVC=yves

echo "Waiting for stack to come up (it may take several minutes) ..."
docker wait ${PROJECT}${ENV}_init_1
docker exec -e PUBLIC_YVES_DOMAIN=$YVES_SVC ${PROJECT}${ENV}_yves_1 /entrypoint.sh codeception
