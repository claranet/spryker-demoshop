#!/bin/bash
set -e -o pipefail

RETRY=600
SLEEP=1

docker pull $image:$tagci

./docker/run devel up -d 

printf "Waiting for stack to come up "
while [ $RETRY -ge 0 ]; do
    if nc -z localhost 2308; then 
        break 
    fi
    printf "."
    let RETRY-=1
    sleep $SLEEP
done

if [ $RETRY -le 0 ]; then
    printf "\nHit timeout while waiting for services!\n"
    exit 1
else
    printf "\nServices ready to be tested ...\n"
fi

curl -v http://localhost:2380/cart
