#!/bin/sh

sectionText "Copy config_local.php to $WORKDIR/config/Shared/"
cp $WORKDIR/docker/config_local.php $WORKDIR/config/Shared/config_local.php
