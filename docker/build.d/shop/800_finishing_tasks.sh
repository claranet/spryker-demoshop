#!/bin/sh

sectionText "Create spryker cache dir"
mkdir -pv $WORKDIR/cache $WORKDIR/data/DE/cache/Yves $WORKDIR/data/DE/cache/Zed &>> $BUILD_LOG
chown -R www-data: $WORKDIR/cache $WORKDIR/data/DE/cache
