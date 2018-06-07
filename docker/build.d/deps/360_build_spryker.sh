#!/bin/sh

sectionText "Copy config_local.php to $WORKDIR/config/Shared/"
cp $WORKDIR/docker/config_local.php $WORKDIR/config/Shared/config_local.php

create_cache_dirs() {
    for store in $STORES; do
        mkdir -pv $WORKDIR/data/$store/cache/Yves $WORKDIR/data/$store/cache/Zed
        mkdir -pv $WORKDIR/cache/$store/Yves/twig mkdir -pv $WORKDIR/cache/$store/Zed/twig
    done
}

sectionText "Create spryker cache dir"
create_cache_dirs &>> $BUILD_LOG

spryker_installer --groups=build

chown -R www-data: $WORKDIR/cache $WORKDIR/data
