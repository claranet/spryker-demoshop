#!/bin/sh

ZED_JOB="zed"
YVES_JOB="yves"

if [ ! -z "$ASSET_ENV" ]; then
    ZED_JOB="$ZED_JOB:$ASSET_ENV"
    YVES_JOB="$YVES_JOB:$ASSET_ENV"
fi

sectionText "Build assets for Zed [$ASSET_ENV]"
$NPM run $ZED_JOB

sectionText "Build assets for Yves [$ASSET_ENV]"
$NPM run $YVES_JOB
