#!/bin/bash 

DIR="$(dirname $0)"
PROJECT="spryker"
pushd $DIR
docker-compose -p $PROJECT $*
popd
