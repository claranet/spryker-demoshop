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

sectionText "Spryker Installer for build artifacts"
spryker_installer --groups=build

chown -R www-data: $WORKDIR/cache $WORKDIR/data

# As the spryker installer genrated a lot of php files we need to regenerate 
# the autoloader file.
# TODO: Check why php-base 450_optimize_composer_autoloader.sh doesn't work
sectionText "Regenerate composers autoload.php"
eatmydata composer dump-autoload &>> $BUILD_LOG
